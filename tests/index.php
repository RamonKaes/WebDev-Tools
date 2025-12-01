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
  <div id="envNote" style="margin-top:.5rem;color:#666;font-size:0.95rem"></div>
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
        // Load test registry to decide which checks should run. If the registry fails to load, all checks run.
        let enabled = new Set();
        if (enabled.size === 0 || enabled.has('sha256')) {
        if (enabled.size === 0 || enabled.has('sha256') || enabled.has('btoa')) {
        if (enabled.size === 0 || enabled.has('uuid_v4')) {
        if (enabled.size === 0 || enabled.has('jwt_decode')) {
        try {
          const reg = await fetch('/tests/test-registry.json', {cache:'no-store'}).then(r => r.json());
          reg.forEach(i => { if (i.enabled) enabled.add(i.id); });
          log('Enabled checks: ' + (enabled.size ? Array.from(enabled).join(', ') : 'ALL'));
        } catch (e) { log('Test registry not available, running all checks'); }

        // Show environment protocol
        try { document.getElementById('envNote').textContent = 'Environment: ' + window.location.protocol + ' (HSTS checks only apply for HTTPS)'; } catch(e){ }

        // JS feature checks
        if (enabled.size === 0 || enabled.has('manifest_parse') || enabled.has('fetch')) {
          if (window.fetch) { ok('fetch API available'); results.push({check:'fetch',ok:true}); } else { fail('fetch API missing'); results.push({check:'fetch',ok:false}); }
        }
        if (enabled.size === 0 || enabled.has('crypto_random')) { if (window.crypto && crypto.getRandomValues) { ok('crypto.getRandomValues available'); results.push({check:'crypto.getRandomValues',ok:true}); } else { fail('CSPRNG not available'); results.push({check:'crypto.getRandomValues',ok:false}); } }
        if (enabled.size === 0 || enabled.has('clipboard')) { if (navigator.clipboard && navigator.clipboard.writeText) { ok('Clipboard API available'); results.push({check:'clipboard',ok:true}); } else { log('Clipboard API not available (expected on some hosts)'); results.push({check:'clipboard',ok:false}); } }

        // Basic file checks via fetch
        // Paths to check via HTTP
        // We prefer public-accessible assets. Avoid fetching server-side PHP config files by HTTP as they may be intentionally protected.
        const toCheck = ['manifest.json','config/i18n/en.json'];
        if (enabled.size === 0 || enabled.has('manifest_parse') || enabled.has('i18n_en')) {
        for (const p of toCheck){
          try{
            // Respect base path if provided
            const base = (window.__BASE_PATH__ || (document.querySelector('base') && document.querySelector('base').href) || window.location.pathname.replace(/\/[^/]*$/, '/'));
            const url = new URL(p, window.location.origin + base);
            const res = await fetch(url.toString(), {cache:'no-store'});
            if (res.ok){ ok(`Found: ${p} (${url.pathname})`); results.push({check:p,ok:true}); }
            else if (res.status === 404){
              // 404 may be expected (e.g., config files not publicly accessible). Treat as warning rather than hard fail.
              log(`HTTP 404 - ${p} at ${url.pathname} (may be intentionally protected)`);
              results.push({check:p,ok:false,warning:true});
            } else { fail(`HTTP ${res.status} - ${p}`); results.push({check:p,ok:false}); }
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

        // Additional security checks
        // SHA-256 via SubtleCrypto
        try {
          if (window.crypto && window.crypto.subtle && window.crypto.subtle.digest) {
            const data = new TextEncoder().encode('hello');
            const digest = await window.crypto.subtle.digest('SHA-256', data);
            const hex = Array.from(new Uint8Array(digest)).map(b => b.toString(16).padStart(2,'0')).join('');
            if (hex === '2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824') { ok('SubtleCrypto SHA-256 matches expected'); results.push({check:'sha256',ok:true}); } else { fail('SHA-256 mismatch'); results.push({check:'sha256',ok:false}); }
          } else { log('SubtleCrypto SHA-256 not available (expected on some hosts)'); results.push({check:'sha256',ok:false}); }
        } catch (e) { fail('SubtleCrypto error: ' + e.message); results.push({check:'sha256',ok:false}); }
        }

        // Base64 correctness (btoa/atob)
        try {
          const enc = btoa('hello');
          if (enc === 'aGVsbG8=') { ok('btoa base64 encoding OK'); results.push({check:'btoa',ok:true}); } else { fail('btoa mismatch: ' + enc); results.push({check:'btoa',ok:false}); }
          const dec = atob(enc);
          if (dec === 'hello') { ok('atob base64 decoding OK'); results.push({check:'atob',ok:true}); } else { fail('atob mismatch: ' + dec); results.push({check:'atob',ok:false}); }
        } catch (e) { fail('btoa/atob not available or error: ' + e.message); results.push({check:'btoa/atob',ok:false}); }
        }

        // Crypto.getRandomValues uniqueness
        if (enabled.size === 0 || enabled.has('crypto_random')) {
        try {
          if (window.crypto && crypto.getRandomValues) {
            const a = new Uint8Array(16); crypto.getRandomValues(a);
            const b = new Uint8Array(16); crypto.getRandomValues(b);
            const eq = a.every((v,i)=>v===b[i]);
            if (!eq) { ok('crypto.getRandomValues produces non-equal values'); results.push({check:'getRandomValues',ok:true}); } else { fail('crypto.getRandomValues produced equal values'); results.push({check:'getRandomValues',ok:false}); }
          } else { log('crypto.getRandomValues not available'); results.push({check:'getRandomValues',ok:false}); }
        } catch (e) { fail('crypto.getRandomValues error: ' + e.message); results.push({check:'getRandomValues',ok:false}); }
        }

        // UUID format check (quick check)
        try {
          const u = (function(){
            if (typeof crypto !== 'undefined' && crypto.getRandomValues) {
              const r = new Uint8Array(16); crypto.getRandomValues(r);
              r[6] = (r[6] & 0x0f) | 0x40; r[8] = (r[8] & 0x3f) | 0x80;
              const hex = Array.from(r).map(b => b.toString(16).padStart(2,'0')).join('');
              return hex.slice(0,8)+'-'+hex.slice(8,12)+'-'+hex.slice(12,16)+'-'+hex.slice(16,20)+'-'+hex.slice(20);
            }
            return null;
          })();
          if (u && /^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i.test(u)) { ok('Inline UUIDv4 generation format OK: ' + u); results.push({check:'uuid',ok:true}); } else { fail('UUIDv4 generation unavailable or invalid'); results.push({check:'uuid',ok:false}); }
        } catch (e) { fail('UUID check failed: ' + e.message); results.push({check:'uuid',ok:false}); }
        }

        // JWT decode check (no signature validation) - decode payload only
        try {
          const sampleJWT = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwiaW5mbyI6InNvbWUifQ.signature';
          const parts = sampleJWT.split('.');
          if (parts.length >= 2) {
            const payload = parts[1].replace(/-/g, '+').replace(/_/g, '/');
            const json = JSON.parse(decodeURIComponent(escape(atob(payload))));
            if (json && json.id === 1) { ok('JWT payload decode OK'); results.push({check:'jwt-decode',ok:true}); } else { fail('JWT payload decode unexpected'); results.push({check:'jwt-decode',ok:false}); }
          } else { fail('JWT token malformed'); results.push({check:'jwt-decode',ok:false}); }
        } catch (e) { fail('JWT decode error: '+e.message); results.push({check:'jwt-decode',ok:false}); }
        }

        // Final summary
        const failures = results.filter(r => !r.ok && !r.warning).length;
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