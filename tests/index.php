<!doctype html>
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
  </style>
</head>
<body>
  <h1>WebDev-Tools — Simple Checks</h1>
  <p>Minimal checks for hosting environments that don't support Node. Click <strong>Run checks</strong> to run a small set of checks in the browser.</p>
  <div class="controls">
    <button id="runBtn">Run checks</button>
    <button id="downloadBtn" disabled>Download Report</button>
  </div>
  <pre id="output" class="output" aria-live="polite"></pre>
  <script>
    (function(){
      const out = document.getElementById('output');
      function log(msg){ out.textContent += msg + '\n'; out.scrollTop = out.scrollHeight; }
      function ok(msg){ log('\u2705 ' + msg); }
      function fail(msg){ log('\u274C ' + msg); }
      const results = [];
        async function runChecks(){
          out.textContent = ''; results.length = 0; log('Starting checks...');
        try{ if (window.fetch) { ok('fetch API available'); results.push({check:'fetch',ok:true}); } else { fail('fetch API missing'); results.push({check:'fetch',ok:false}); } } catch(e){ fail('fetch check failed: ' + e.message); }
        try{ if (window.crypto && crypto.getRandomValues) { ok('crypto.getRandomValues available'); results.push({check:'getRandomValues',ok:true}); } else { fail('CSPRNG not available'); results.push({check:'getRandomValues',ok:false}); } } catch(e){ fail('getRandomValues check failed: ' + e.message); }
        try{ const enc = btoa('hello'); if (enc === 'aGVsbG8=') { ok('btoa OK'); results.push({check:'btoa',ok:true}); } else { fail('btoa mismatch'); results.push({check:'btoa',ok:false}); } const dec = atob(enc); if (dec === 'hello'){ ok('atob OK'); results.push({check:'atob',ok:true}); } else { fail('atob mismatch'); results.push({check:'atob',ok:false}); } } catch(e){ fail('btoa/atob error: ' + e.message); }
        try{ const sampleJWT = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwiaW5mbyI6InNvbWUifQ.signature'; const parts = sampleJWT.split('.'); if (parts.length >= 2){ const payload = parts[1].replace(/-/g,'+').replace(/_/g,'/'); const json = JSON.parse(atob(payload)); if (json && json.id === 1) { ok('JWT decode OK'); results.push({check:'jwt-decode',ok:true}); } else { fail('JWT decode unexpected'); results.push({check:'jwt-decode',ok:false}); } } else { fail('JWT token malformed'); results.push({check:'jwt-decode',ok:false}); } } catch(e){ fail('JWT decode error: ' + e.message); }

        // Endpoint checks from checks.json
        try {
            // Read checks list and run fetches (relative to current base root; support both root and subpath hosting)
            try {
              // compute the base directory (tests/ folder) relative to the current script,
              // and use it to resolve checks.json and endpoint entries.
                const baseHref = new URL('.', window.location.href).toString();
                const origin = window.location.origin;
                // derive site base root (where the tools live), strip '/tests/' if present
                const pathname = window.location.pathname || '/';
                let siteRoot = '/';
                if (pathname.includes('/tests/')) {
                  siteRoot = pathname.substring(0, pathname.indexOf('/tests/')) + '/';
                } else {
                  siteRoot = pathname.replace(/\/[^/]*$/, '/');
                }
                if (!siteRoot.endsWith('/')) siteRoot += '/';
                const checksUrl = new URL('checks.json', baseHref).toString();
                log('Site root: ' + origin + siteRoot);
                log('Loading checks.json from: ' + checksUrl);
                const resp = await fetch(checksUrl, {cache:'no-store'});
              if (resp.ok) {
              const list = await resp.json();
            for (const p of list){
              try{
                    // If the path starts with a slash, treat as absolute host-path, otherwise it's relative to tests dir.
                    const url = p.startsWith('/') ? new URL(p, origin) : new URL(p, origin + siteRoot);
                    log('Fetch: ' + url.toString());
                const r = await fetch(url.toString(), {cache:'no-store'});
                if (r.ok){ ok(`Found: ${p} (${r.status})`); results.push({check:p,ok:true}); }
                else if (r.status === 404){ fail(`HTTP 404: ${p}`); results.push({check:p,ok:false}); }
                else { fail(`HTTP ${r.status}: ${p}`); results.push({check:p,ok:false}); }
              } catch(e2){ fail(`Failed to fetch ${p} — ${e2.message}`); results.push({check:p,ok:false}); }
            }
          } else { log('checks.json not available (skipping): ' + resp.status); }
          } catch(e){ log('Failed to load checks.json: ' + e.message); }
        } catch(e){ log('Endpoint checks failed: ' + e.message); results.push({check:'endpoints',ok:false,error:e.message}); }

        const failures = results.filter(r => !r.ok && !r.warning).length; if (failures === 0) ok('All checks passed'); else fail(`${failures} checks failed`);
        document.getElementById('downloadBtn').disabled = false;
      }
      document.getElementById('runBtn').addEventListener('click', runChecks);
      document.getElementById('downloadBtn').addEventListener('click', function(){ const data = {timestamp:new Date().toISOString(), results}; const blob = new Blob([JSON.stringify(data,null,2)],{type:'application/json'}); const u = URL.createObjectURL(blob); const a = document.createElement('a'); a.href = u; a.download = 'webdev-tools-checks-' + Date.now() + '.json'; document.body.appendChild(a); a.click(); setTimeout(()=>{ URL.revokeObjectURL(u); a.remove(); }, 750); });
    })();
  </script>
</body>
</html>
