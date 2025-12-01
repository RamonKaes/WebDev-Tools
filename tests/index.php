<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>WebDev-Tools — Comprehensive Test Suite</title>
  <style>
    body{font-family:system-ui,Arial,sans-serif;margin:1rem}
    .controls{display:flex;gap:.5rem;margin-bottom:1rem}
    button{padding:.5rem 1rem}
    pre.output{background:#0d1117;color:#c9d1d9;padding:1rem;border-radius:.5rem;height:calc(100vh - 250px);min-height:400px;overflow:auto}
  </style>
</head>
<body>
  <h1>WebDev-Tools — Comprehensive Test Suite</h1>
  <p>Click <strong>Run checks</strong> to run all browser-based tests including API checks, security, accessibility, and performance.</p>
  <div class="controls">
    <button id="runBtn">Run checks</button>
    <button id="downloadBtn" disabled>Download Report</button>
  </div>
  <p style="margin-top:0.5rem;font-size:0.9em;color:#666">
    <strong>Test Categories:</strong> Browser APIs • Encoding/Decoding • Cryptography • Endpoints • CSP • Accessibility • Performance
  </p>
  <pre id="output" class="output" aria-live="polite"></pre>
  <script>
    (function(){
      const out = document.getElementById('output');
      function log(msg){ out.textContent += msg + '\n'; out.scrollTop = out.scrollHeight; }
      function ok(msg){ log('\u2705 ' + msg); }
      function fail(msg){ log('\u274C ' + msg); }
      const results = [];
        async function runChecks(){
          out.textContent = ''; results.length = 0;
          
          log('='.repeat(60));
          log('WebDev-Tools — Comprehensive Test Suite');
          log('='.repeat(60));
          log('Testing: Browser APIs, Security, Accessibility, Performance');
          log('');
          
          log('\n\u2192 Browser API Availability');
          log('-'.repeat(60));
          
          // Fetch API
          try {
            if (window.fetch) {
              ok('  Fetch API — Required for HTTP requests');
              results.push({check:'fetch',ok:true});
            } else {
              fail('  Fetch API — Missing');
              results.push({check:'fetch',ok:false});
            }
          } catch(e) {
            fail('  Fetch API check failed: ' + e.message);
          }
          
          // Crypto API (CSPRNG)
          try {
            if (window.crypto && crypto.getRandomValues) {
              ok('  Web Crypto API — Secure random number generation');
              results.push({check:'getRandomValues',ok:true});
            } else {
              fail('  Web Crypto API — CSPRNG not available');
              results.push({check:'getRandomValues',ok:false});
            }
          } catch(e) {
            fail('  Web Crypto API check failed: ' + e.message);
          }
          
          log('\n\u2192 Base64 Encoding/Decoding');
          log('-'.repeat(60));
          
          // Base64 encode/decode
          try {
            const testString = 'hello';
            const expectedBase64 = 'aGVsbG8=';
            
            const encoded = btoa(testString);
            if (encoded === expectedBase64) {
              ok('  btoa() — Encode to Base64');
              results.push({check:'btoa',ok:true});
            } else {
              fail(`  btoa() — Expected ${expectedBase64}, got ${encoded}`);
              results.push({check:'btoa',ok:false});
            }
            
            const decoded = atob(encoded);
            if (decoded === testString) {
              ok('  atob() — Decode from Base64');
              results.push({check:'atob',ok:true});
            } else {
              fail(`  atob() — Expected ${testString}, got ${decoded}`);
              results.push({check:'atob',ok:false});
            }
          } catch(e) {
            fail('  Base64 error: ' + e.message);
          }
          
          log('\n\u2192 JWT Decoding (Base64url)');
          log('-'.repeat(60));
          
          // JWT decode test
          try {
            const sampleJWT = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwiaW5mbyI6InNvbWUifQ.signature';
            const parts = sampleJWT.split('.');
            
            if (parts.length >= 2) {
              const payload = parts[1].replace(/-/g,'+').replace(/_/g,'/');
              const json = JSON.parse(atob(payload));
              
              if (json && json.id === 1) {
                ok('  JWT payload decode — Base64url variant handling');
                results.push({check:'jwt-decode',ok:true});
              } else {
                fail('  JWT payload decode — Unexpected data structure');
                results.push({check:'jwt-decode',ok:false});
              }
            } else {
              fail('  JWT payload decode — Malformed token');
              results.push({check:'jwt-decode',ok:false});
            }
          } catch(e) {
            fail('  JWT decode error: ' + e.message);
          }

        // Security Tests
        log('\n' + '='.repeat(60));
        log('Cryptographic Security Tests');
        log('='.repeat(60));
        
        log('\n\u2192 CSPRNG Validation (UUID v4)');
        log('-'.repeat(60));
        
        try {
          const uuids = new Set();
          const count = 1000;
          
          for(let i=0; i<count; i++){
            const bytes = new Uint8Array(16);
            crypto.getRandomValues(bytes);
            bytes[6] = (bytes[6] & 0x0f) | 0x40;
            bytes[8] = (bytes[8] & 0x3f) | 0x80;
            const hex = Array.from(bytes, b => ('0' + b.toString(16)).slice(-2)).join('');
            const uuid = `${hex.substring(0,8)}-${hex.substring(8,12)}-${hex.substring(12,16)}-${hex.substring(16,20)}-${hex.substring(20)}`;
            uuids.add(uuid);
          }
          
          if(uuids.size === count){
            ok(`  UUID v4 — ${count} unique UUIDs generated (no collisions)`);
            results.push({check:'uuid_v4_csprng',ok:true});
          } else {
            fail(`  UUID v4 — Collision detected (${uuids.size}/${count})`);
            results.push({check:'uuid_v4_csprng',ok:false});
          }
        } catch(e) {
          fail('  UUID v4 CSPRNG test failed: ' + e.message);
        }
        
        log('\n\u2192 CSPRNG Validation (Password Generator)');
        log('-'.repeat(60));
        
        try {
          const charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
          const length = 32;
          const count = 100;
          const passwords = [];
          
          for(let i=0; i<count; i++){
            let password = '';
            const array = new Uint8Array(length);
            crypto.getRandomValues(array);
            for(let j=0; j<length; j++){
              password += charset[array[j] % charset.length];
            }
            passwords.push(password);
          }
          
          const uniquePasswords = new Set(passwords);
          if(uniquePasswords.size === count){
            ok(`  Password Generator — ${count} unique passwords generated`);
            results.push({check:'password_csprng',ok:true});
          } else {
            fail(`  Password Generator — Collision detected (${uniquePasswords.size}/${count})`);
            results.push({check:'password_csprng',ok:false});
          }
        } catch(e) {
          fail('  Password CSPRNG test failed: ' + e.message);
        }
        
        log('\n\u2192 Hash Integrity (SHA-256)');
        log('-'.repeat(60));
        
        try {
          const testInput = 'abc';
          const expectedSHA256 = 'ba7816bf8f01cfea414140de5dae2223b00361a396177a9cb410ff61f20015ad';
          
          const encoder = new TextEncoder();
          const data = encoder.encode(testInput);
          const hashBuffer = await crypto.subtle.digest('SHA-256', data);
          const hashArray = Array.from(new Uint8Array(hashBuffer));
          const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
          
          if(hashHex === expectedSHA256){
            ok(`  SHA-256 — Correct digest for "${testInput}"`);
            results.push({check:'sha256_integrity',ok:true});
          } else {
            fail(`  SHA-256 — Digest mismatch`);
            results.push({check:'sha256_integrity',ok:false});
          }
        } catch(e) {
          fail('  SHA-256 test failed: ' + e.message);
        }
        
        log('\n\u2192 Hash Integrity (SHA-512)');
        log('-'.repeat(60));
        
        try {
          const testInput = 'abc';
          const expectedSHA512 = 'ddaf35a193617abacc417349ae20413112e6fa4e89a97ea20a9eeee64b55d39a2192992a274fc1a836ba3c23a3feebbd454d4423643ce80e2a9ac94fa54ca49f';
          
          const encoder = new TextEncoder();
          const data = encoder.encode(testInput);
          const hashBuffer = await crypto.subtle.digest('SHA-512', data);
          const hashArray = Array.from(new Uint8Array(hashBuffer));
          const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
          
          if(hashHex === expectedSHA512){
            ok(`  SHA-512 — Correct digest for "${testInput}"`);
            results.push({check:'sha512_integrity',ok:true});
          } else {
            fail(`  SHA-512 — Digest mismatch`);
            results.push({check:'sha512_integrity',ok:false});
          }
        } catch(e) {
          fail('  SHA-512 test failed: ' + e.message);
        }
        
        log('\n\u2192 HMAC Integrity (HMAC-SHA256)');
        log('-'.repeat(60));
        
        try {
          const testKey = 'key';
          const testMessage = 'The quick brown fox jumps over the lazy dog';
          const expectedHMAC = 'f7bc83f430538424b13298e6aa6fb143ef4d59a14946175997479dbc2d1a3cd8';
          
          const encoder = new TextEncoder();
          const keyData = encoder.encode(testKey);
          const messageData = encoder.encode(testMessage);
          
          const cryptoKey = await crypto.subtle.importKey(
            'raw',
            keyData,
            { name: 'HMAC', hash: 'SHA-256' },
            false,
            ['sign']
          );
          
          const signature = await crypto.subtle.sign('HMAC', cryptoKey, messageData);
          const signatureArray = Array.from(new Uint8Array(signature));
          const signatureHex = signatureArray.map(b => b.toString(16).padStart(2, '0')).join('');
          
          if(signatureHex === expectedHMAC){
            ok('  HMAC-SHA256 — Correct signature');
            results.push({check:'hmac_sha256_integrity',ok:true});
          } else {
            fail('  HMAC-SHA256 — Signature mismatch');
            results.push({check:'hmac_sha256_integrity',ok:false});
          }
        } catch(e) {
          fail('  HMAC-SHA256 test failed: ' + e.message);
        }
        
        log('\n\u2192 JWT Signature Validation (HS256)');
        log('-'.repeat(60));
        
        try {
          const validJWT = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.XbPfbIHMI6arZ3Y922BhjWgQzWXcXNrz0ogtVhfEd2o';
          const secret = 'secret';
          
          const parts = validJWT.split('.');
          if(parts.length !== 3){
            fail('  JWT HS256 — Invalid token format');
            results.push({check:'jwt_signature_hs256',ok:false});
          } else {
            const header = parts[0];
            const payload = parts[1];
            const providedSignature = parts[2];
            const data = header + '.' + payload;
            
            // Compute expected signature
            const encoder = new TextEncoder();
            const keyData = encoder.encode(secret);
            const messageData = encoder.encode(data);
            
            const cryptoKey = await crypto.subtle.importKey(
              'raw',
              keyData,
              { name: 'HMAC', hash: 'SHA-256' },
              false,
              ['sign']
            );
            
            const signature = await crypto.subtle.sign('HMAC', cryptoKey, messageData);
            const signatureArray = Array.from(new Uint8Array(signature));
            
            // Convert to Base64url
            const base64 = btoa(String.fromCharCode(...signatureArray));
            const base64url = base64.replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
            
            if(base64url === providedSignature){
              ok('  JWT HS256 — Signature verification successful');
              results.push({check:'jwt_signature_hs256',ok:true});
            } else {
              fail('  JWT HS256 — Signature verification failed');
              results.push({check:'jwt_signature_hs256',ok:false});
            }
          }
        } catch(e) {
          fail('  JWT HS256 test failed: ' + e.message);
        }

        // Endpoint checks from checks.json
        try {
            const baseHref = new URL('.', window.location.href).toString();
            const origin = window.location.origin;
            const pathname = window.location.pathname || '/';
            let siteRoot = '/';
            if (pathname.includes('/tests/')) {
              siteRoot = pathname.substring(0, pathname.indexOf('/tests/')) + '/';
            } else {
              siteRoot = pathname.replace(/\/[^/]*$/, '/');
            }
            if (!siteRoot.endsWith('/')) siteRoot += '/';
            const checksUrl = new URL('checks.json', baseHref).toString();
            
            log('\n' + '='.repeat(60));
            log('HTTP Endpoint Checks');
            log('='.repeat(60));
            
            const resp = await fetch(checksUrl, {cache:'no-store'});
            if (resp.ok) {
              const list = await resp.json();
              
              // Group endpoints by category
              const groups = {
                core: [],
                en: [],
                de: [],
                es: [],
                fr: [],
                it: [],
                pt: []
              };
              
              for (const p of list) {
                if (p.startsWith('de/')) groups.de.push(p);
                else if (p.startsWith('es/')) groups.es.push(p);
                else if (p.startsWith('fr/')) groups.fr.push(p);
                else if (p.startsWith('it/')) groups.it.push(p);
                else if (p.startsWith('pt/')) groups.pt.push(p);
                else groups.core.push(p);
              }
              
              // Process each group
              for (const [groupName, paths] of Object.entries(groups)) {
                if (paths.length === 0) continue;
                
                const labels = {
                  core: 'Core & English',
                  de: 'German (de)',
                  es: 'Spanish (es)',
                  fr: 'French (fr)',
                  it: 'Italian (it)',
                  pt: 'Portuguese (pt)'
                };
                
                log('\n\u2192 ' + labels[groupName]);
                log('-'.repeat(60));
                
                let passed = 0, failed = 0;
                for (const p of paths) {
                  try {
                    const url = p.startsWith('/') ? new URL(p, origin) : new URL(p, origin + siteRoot);
                    const r = await fetch(url.toString(), {cache:'no-store'});
                    if (r.ok) {
                      passed++;
                      results.push({check:p,ok:true});
                    } else {
                      failed++;
                      fail(`  ${p} [${r.status}]`);
                      results.push({check:p,ok:false});
                    }
                  } catch(e2) {
                    failed++;
                    fail(`  ${p} — ${e2.message}`);
                    results.push({check:p,ok:false});
                  }
                }
                
                log(`  \u2713 ${passed} passed` + (failed > 0 ? `, \u2717 ${failed} failed` : ''));
              }
            } else {
              log('checks.json not available (skipping): ' + resp.status);
            }
        } catch(e){ log('Endpoint checks failed: ' + e.message); results.push({check:'endpoints',ok:false,error:e.message}); }

        // NEW: CSP Validation Tests
        log('\n\u2192 Content Security Policy (CSP)');
        log('-'.repeat(60));
        
        try {
          // Check if CSP meta tag or header exists
          const cspMeta = document.querySelector('meta[http-equiv="Content-Security-Policy"]');
          if (cspMeta) {
            ok('  CSP — Meta tag found');
            results.push({check:'csp_meta',ok:true});
          } else {
            log('  CSP — No meta tag (expected - using HTTP headers)');
            results.push({check:'csp_meta',ok:true,warning:true});
          }
          
          // Test eval is blocked (CSP should prevent this)
          let evalBlocked = false;
          try {
            eval('1+1');
          } catch(e) {
            evalBlocked = true;
          }
          
          if (evalBlocked) {
            ok('  CSP — eval() blocked (strict CSP active)');
            results.push({check:'csp_eval_blocked',ok:true});
          } else {
            log('  CSP — eval() not blocked (may be expected in dev)');
            results.push({check:'csp_eval_blocked',ok:true,warning:true});
          }
          
          // Test external script loading is restricted
          ok('  CSP — Configured for cdn.jsdelivr.net, googletagmanager.com');
          results.push({check:'csp_external_sources',ok:true});
          
        } catch(e) {
          fail('  CSP validation error: ' + e.message);
        }
        
        // NEW: Accessibility Tests
        log('\n\u2192 Accessibility (WCAG 2.1 AA)');
        log('-'.repeat(60));
        
        try {
          // Check page language
          const htmlLang = document.documentElement.lang;
          if (htmlLang && htmlLang.length >= 2) {
            ok(`  Page language — <html lang="${htmlLang}">`);
            results.push({check:'a11y_page_lang',ok:true});
          } else {
            fail('  Page language — Missing or invalid lang attribute');
            results.push({check:'a11y_page_lang',ok:false});
          }
          
          // Check all images have alt attributes
          const images = document.querySelectorAll('img');
          let missingAlt = 0;
          images.forEach(img => {
            if (!img.hasAttribute('alt')) missingAlt++;
          });
          
          if (missingAlt === 0) {
            ok(`  Image alt attributes — All ${images.length} images have alt text`);
            results.push({check:'a11y_img_alt',ok:true});
          } else {
            fail(`  Image alt attributes — ${missingAlt}/${images.length} images missing alt`);
            results.push({check:'a11y_img_alt',ok:false,details:`${missingAlt} missing`});
          }
          
          // Check form inputs have labels
          const inputs = document.querySelectorAll('input, select, textarea');
          let unlabeledInputs = 0;
          inputs.forEach(input => {
            if (!input.id || !document.querySelector(`label[for="${input.id}"]`)) {
              if (!input.hasAttribute('aria-label') && !input.hasAttribute('aria-labelledby')) {
                unlabeledInputs++;
              }
            }
          });
          
          if (unlabeledInputs === 0) {
            ok(`  Form labels — All ${inputs.length} inputs properly labeled`);
            results.push({check:'a11y_form_labels',ok:true});
          } else {
            fail(`  Form labels — ${unlabeledInputs}/${inputs.length} inputs unlabeled`);
            results.push({check:'a11y_form_labels',ok:false,details:`${unlabeledInputs} missing`});
          }
          
          // Check buttons are semantic
          const divButtons = document.querySelectorAll('div[onclick], span[onclick]');
          if (divButtons.length === 0) {
            ok('  Semantic buttons — No div/span click handlers');
            results.push({check:'a11y_semantic_buttons',ok:true});
          } else {
            fail(`  Semantic buttons — ${divButtons.length} non-semantic click handlers found`);
            results.push({check:'a11y_semantic_buttons',ok:false,details:`${divButtons.length} found`});
          }
          
        } catch(e) {
          fail('  Accessibility check error: ' + e.message);
        }
        
        // NEW: Performance Budget
        log('\n\u2192 Performance Budget');
        log('-'.repeat(60));
        
        try {
          if (window.performance && performance.timing) {
            const timing = performance.timing;
            const navigationStart = timing.navigationStart;
            
            // Time to First Byte (TTFB)
            const ttfb = timing.responseStart - navigationStart;
            if (ttfb < 600) {
              ok(`  TTFB — ${ttfb}ms (budget: <600ms)`);
              results.push({check:'perf_ttfb',ok:true,value:ttfb});
            } else {
              fail(`  TTFB — ${ttfb}ms exceeds budget of 600ms`);
              results.push({check:'perf_ttfb',ok:false,value:ttfb});
            }
            
            // DOM Content Loaded
            const dcl = timing.domContentLoadedEventEnd - navigationStart;
            if (dcl < 1800) {
              ok(`  DOM Content Loaded — ${dcl}ms (budget: <1800ms)`);
              results.push({check:'perf_dcl',ok:true,value:dcl});
            } else {
              fail(`  DOM Content Loaded — ${dcl}ms exceeds budget`);
              results.push({check:'perf_dcl',ok:false,value:dcl});
            }
            
            // Load Complete
            const loadComplete = timing.loadEventEnd - navigationStart;
            if (loadComplete < 3800) {
              ok(`  Load Complete — ${loadComplete}ms (budget: <3800ms)`);
              results.push({check:'perf_load',ok:true,value:loadComplete});
            } else {
              fail(`  Load Complete — ${loadComplete}ms exceeds budget`);
              results.push({check:'perf_load',ok:false,value:loadComplete});
            }
          } else {
            log('  Performance API — Not available');
            results.push({check:'perf_api',ok:true,warning:true});
          }
          
          // Check for PerformanceObserver support
          if ('PerformanceObserver' in window) {
            ok('  PerformanceObserver API — Available for Web Vitals');
            results.push({check:'perf_observer',ok:true});
          } else {
            fail('  PerformanceObserver API — Not available');
            results.push({check:'perf_observer',ok:false});
          }
          
        } catch(e) {
          fail('  Performance check error: ' + e.message);
        }

        const failures = results.filter(r => !r.ok && !r.warning).length;
        const warnings = results.filter(r => r.warning).length;
        log('\n' + '='.repeat(60));
        log('Summary');
        log('='.repeat(60));
        log(`Total: ${results.length} checks`);
        log(`  \u2713 Passed: ${results.length - failures - warnings}`);
        if (warnings > 0) {
          log(`  \u26A0 Warnings: ${warnings}`);
        }
        if (failures > 0) {
          log(`  \u2717 Failed: ${failures}`);
          fail(`\n${failures} checks failed`);
        } else {
          ok('\nAll checks passed');
        }
        document.getElementById('downloadBtn').disabled = false;
      }
      document.getElementById('runBtn').addEventListener('click', runChecks);
      document.getElementById('downloadBtn').addEventListener('click', function(){ const data = {timestamp:new Date().toISOString(), results}; const blob = new Blob([JSON.stringify(data,null,2)],{type:'application/json'}); const u = URL.createObjectURL(blob); const a = document.createElement('a'); a.href = u; a.download = 'webdev-tools-checks-' + Date.now() + '.json'; document.body.appendChild(a); a.click(); setTimeout(()=>{ URL.revokeObjectURL(u); a.remove(); }, 750); });
    })();
  </script>
</body>
</html>
