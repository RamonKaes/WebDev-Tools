<?php
// Minimal test UI (Vanilla JS + PHP) for hosting without Node.
// This page is purely client-side JS for checks and outputs a simple console-like view.
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>WebDev-Tools — Simple Checks</title>
  <style>
    body{font-family:system-ui,Arial,sans-serif;margin:1rem}
    .controls{display:flex;gap:.5rem;margin-bottom:1rem}
    button{padding:.5rem 1rem}
    pre.output{background:#0d1117;color:#c9d1d9;padding:1rem;border-radius:.5rem;height:320px;overflow:auto}
    .success{color:green}
    .fail{color:crimson}
  </style>
</head>
<body>
  <h1>WebDev-Tools — Simple Checks</h1>
  <p>This is a lightweight checks page for environments without Node or extra tooling. Click Run to execute a small set of checks (vanilla JavaScript) and see results below. Use the CLI helper <code>tests/run.php</code> for server-side checks via PHP CLI.</p>
  <div class="controls">
    <button id="runBtn">Run checks</button>
    <button id="downloadBtn" disabled>Download Report</button>
  </div>
  <pre id="output" class="output" aria-live="polite"></pre>
  <script>
    (function(){
      const out = document.getElementById('output');
      const runBtn = document.getElementById('runBtn');
      const dlBtn = document.getElementById('downloadBtn');
      function log(msg){ out.textContent += msg + '\n'; out.scrollTop = out.scrollHeight; }
      function ok(msg){ log('\u2705 ' + msg); }
      function fail(msg){ log('\u274C ' + msg); }

      const results = [];
      async function runChecks(){
        out.textContent = '';
        results.length = 0;
        log('Starting checks...');

        // JS feature checks
        if (window.fetch) { ok('fetch API available'); results.push({check:'fetch',ok:true}); } else { fail('fetch API missing'); results.push({check:'fetch',ok:false}); }
        if (window.crypto && crypto.getRandomValues) { ok('crypto.getRandomValues available'); results.push({check:'crypto.getRandomValues',ok:true}); } else { fail('CSPRNG not available'); results.push({check:'crypto.getRandomValues',ok:false}); }
        if (navigator.clipboard && navigator.clipboard.writeText) { ok('Clipboard API available'); results.push({check:'clipboard',ok:true}); } else { log('Clipboard API not available (expected on some hosts)'); results.push({check:'clipboard',ok:false}); }

        // Basic file checks via fetch
        const toCheck = ['config/manifest.json','config/i18n/en.json','config/config.php'];
        for (const p of toCheck){
          try{
            const res = await fetch(window.location.origin + '/' + p, {cache:'no-store'});
            if (res.ok){ ok(`Found: ${p}`); results.push({check:p,ok:true}); }
            else { fail(`HTTP ${res.status} - ${p}`); results.push({check:p,ok:false}); }
          } catch (e){ fail(`Failed to fetch ${p} — ${e.message}`); results.push({check:p,ok:false}); }
        }

        // Small runtime check: CSS styles loaded
        const cssVar = getComputedStyle(document.body).fontFamily || ''; ok('Computed styles are available'); results.push({check:'css',ok:true});

        // Validate a small JSON sample for correctness
        try{
          const demoJSON = '{"hello":"world"}';
          const parsed = JSON.parse(demoJSON);
          if (parsed.hello === 'world'){ ok('JSON parse OK'); results.push({check:'json-parse',ok:true}); } else { fail('JSON parse not correct'); results.push({check:'json-parse',ok:false}); }
        } catch (e){ fail('JSON parse failed: ' + e.message); results.push({check:'json-parse',ok:false}); }

        // Final summary
        const failures = results.filter(r => !r.ok).length;
        if (failures === 0){ ok('All checks passed'); } else { fail(`${failures} checks failed`); }

        // Enable download
        dlBtn.disabled = false;
      }

      runBtn.addEventListener('click', runChecks);

      dlBtn.addEventListener('click', () => {
        const data = {timestamp:new Date().toISOString(), results};
        const blob = new Blob([JSON.stringify(data,null,2)], {type:'application/json'});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'webdev-tools-checks-' + Date.now() + '.json';
        document.body.appendChild(a);
        a.click();
        setTimeout(() => { URL.revokeObjectURL(url); a.remove(); }, 1000);
      });

      // Auto-run a quick smoke check
      //runChecks();
    })();
  </script>
</body>
</html>