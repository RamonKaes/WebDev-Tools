const { spawnSync } = require('child_process');
const fs = require('fs');
const os = require('os');
const path = require('path');

const SCRIPT = path.join(__dirname, '../../build-tools/check-deploy.sh');

describe('check-deploy.sh', () => {
  let base;
  let repo;

  const git = (...args) => {
    const result = spawnSync('git', args, { cwd: repo, encoding: 'utf8' });
    if (result.status !== 0) throw new Error(result.stderr);
    return result.stdout.trim();
  };
  const write = (file, content = 'x') => {
    fs.mkdirSync(path.dirname(path.join(repo, file)), { recursive: true });
    fs.writeFileSync(path.join(repo, file), content);
  };
  const check = () => spawnSync('bash', [SCRIPT, repo], { encoding: 'utf8' });
  const build = () => {
    write('dist/index.php');
    write('.build-commit', `${git('rev-parse', 'HEAD')}\n`);
  };

  beforeEach(() => {
    base = fs.mkdtempSync(path.join(os.tmpdir(), 'check-deploy-'));
    repo = path.join(base, 'repo');
    fs.mkdirSync(repo);
    git('init', '-q', '-b', 'main');
    git('config', 'user.email', 'test@example.com');
    git('config', 'user.name', 'Test');
    write('.gitignore', 'dist/\n.build-commit\n*.backup\n');
    write('index.php');
    git('add', '.');
    git('commit', '-qm', 'first');
    spawnSync('git', ['clone', '-q', '--bare', repo, path.join(base, 'origin.git')]);
    git('remote', 'add', 'origin', path.join(base, 'origin.git'));
    git('fetch', '-q', 'origin');
  });

  afterEach(() => {
    fs.rmSync(base, { recursive: true, force: true });
  });

  it('accepts a fresh build of origin/main', () => {
    build();
    const result = check();
    expect(result.stderr).toBe('');
    expect(result.status).toBe(0);
  });

  it('refuses another branch', () => {
    git('switch', '-qc', 'feature');
    build();
    expect(check().stderr).toContain("On branch 'feature'");
  });

  it('refuses uncommitted changes', () => {
    build();
    write('index.php', 'changed');
    expect(check().stderr).toContain('uncommitted changes');
  });

  it('refuses a commit that is not on origin/main', () => {
    write('new.php');
    git('add', '.');
    git('commit', '-qm', 'local');
    build();
    expect(check().stderr).toContain('HEAD is not origin/main');
  });

  it('refuses an old or missing build', () => {
    expect(check().stderr).toContain('dist/ is missing');
    build();
    write('.build-commit', 'abc123\n');
    expect(check().stderr).toContain("built from 'abc123'");
  });

  it('refuses backup files in the build', () => {
    build();
    write('dist/config/i18n/it.json.backup');
    expect(check().stderr).toContain('Backup or temporary file in the build: dist/config/i18n/it.json.backup');
  });

  it('refuses a file git does not know', () => {
    write('.gitignore', 'dist/\n.build-commit\nleftover.json\n');
    git('add', '.');
    git('commit', '-qm', 'ignore');
    git('push', '-q', 'origin', 'main');
    write('leftover.json');
    build();
    write('dist/leftover.json');
    const result = check();
    expect(result.status).toBe(1);
    expect(result.stderr).toContain('Not in git, but in the build: leftover.json');
  });

  it('accepts generated files without a counterpart in the checkout', () => {
    build();
    write('dist/assets/css/style.min.css');
    expect(check().status).toBe(0);
  });
});
