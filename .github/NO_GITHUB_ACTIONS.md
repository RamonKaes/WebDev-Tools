Repository Policy: No GitHub Actions

This repository has disabled GitHub Actions to avoid using GitHub Actions minutes.

Local checks and instructions:
- Use `./bin/check` to run local syntax and test checks (PHP lint + optional Node tests).
- Manual steps for running checks locally:
  1) Install PHP and Node if required.
  2) Run `./bin/check` in the repository root.

Alternatives to using GitHub Actions for CI (cost-free options):
1. Self-hosted runner — if you own a machine, you can add a self-hosted runner to execute CI jobs without paying for GitHub minutes.
2. Local test automation — scripts to run tests locally before push/PR.
3. A lightweight CI server under your control (e.g., Jenkins/Gitlab CI) if you want more automation off-GitHub.

If you want to re-enable GitHub Actions later, create a new workflow file and open a PR.
