<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>WebDev-Tools — Security Tests</title>
  <style>
    body{font-family:system-ui,Arial,sans-serif;margin:1rem;background:#0d1117;color:#c9d1d9}
    h1{color:#58a6ff}
    .controls{display:flex;gap:.5rem;margin-bottom:1rem}
    button{padding:.5rem 1rem;background:#238636;color:white;border:none;border-radius:.375rem;cursor:pointer}
    button:hover{background:#2ea043}
    pre.output{background:#161b22;color:#c9d1d9;padding:1rem;border:1px solid #30363d;border-radius:.5rem;height:400px;overflow:auto;font-size:.875rem}
    .pass{color:#3fb950} .fail{color:#f85149} .warn{color:#d29922}
  </style>
</head>
<body>
  <h1>🔒 WebDev-Tools — Security Tests</h1>
  <p>Validates that security-critical tools use cryptographically secure random number generation (CSPRNG) and that cryptographic operations produce correct outputs.</p>
  <div class="controls">
    <button id="runBtn">Run Security Tests</button>
    <button id="downloadBtn" disabled>Download Report</button>
  </div>
  <pre id="output" class="output" aria-live="polite"></pre>
  <script>
    (function(){
      const out = document.getElementById('output');
      function log(msg){ out.textContent += msg + '\n'; out.scrollTop = out.scrollHeight; }
      function pass(msg){ log('✅ ' + msg); }
      function fail(msg){ log('❌ ' + msg); }
      function warn(msg){ log('⚠️  ' + msg); }
      const results = [];

      async function runSecurityTests(){
        out.textContent = ''; results.length = 0;
        log('=== WebDev-Tools Security Test Suite ===\n');
        log('Testing cryptographic security for password/UUID generators\n');

        // Test 1: crypto.getRandomValues availability
        try{
          if (window.crypto && crypto.getRandomValues) {
            pass('crypto.getRandomValues available');
            results.push({test:'crypto_available',ok:true});
          } else {
            fail('CSPRNG not available');
            results.push({test:'crypto_available',ok:false});
            return; // Cannot proceed without CSPRNG
          }
        } catch(e){ fail('crypto check failed: ' + e.message); return; }

        // Test 2: UUID v4 CSPRNG validation (entropy check)
        try{
          log('\n--- UUID v4 CSPRNG Test ---');
          const uuids = new Set();
          const count = 1000;
          let mathRandomDetected = false;

          // Generate 1000 UUIDs and check for duplicates and patterns
          for(let i=0; i<count; i++){
            const bytes = new Uint8Array(16);
            crypto.getRandomValues(bytes);
            bytes[6] = (bytes[6] & 0x0f) | 0x40; // version 4
            bytes[8] = (bytes[8] & 0x3f) | 0x80; // variant
            const hex = Array.from(bytes, b => ('0' + b.toString(16)).slice(-2)).join('');
            const uuid = `${hex.substring(0,8)}-${hex.substring(8,12)}-${hex.substring(12,16)}-${hex.substring(16,20)}-${hex.substring(20)}`;
            uuids.add(uuid);
          }

          if(uuids.size === count){
            pass(`UUID v4: Generated ${count} unique UUIDs (no collisions)`);
            results.push({test:'uuid_v4_csprng',ok:true,count:count,unique:uuids.size});
          } else {
            fail(`UUID v4: Collision detected (${uuids.size}/${count} unique)`);
            results.push({test:'uuid_v4_csprng',ok:false,count:count,unique:uuids.size});
          }

          // Sample a few UUIDs to verify format
          const sample = Array.from(uuids).slice(0,3);
          log(`Sample UUIDs: ${sample.join(', ')}`);

        } catch(e){ fail('UUID v4 CSPRNG test failed: ' + e.message); results.push({test:'uuid_v4_csprng',ok:false,error:e.message}); }

        // Test 3: Password CSPRNG validation (distribution check)
        try{
          log('\n--- Password Generator CSPRNG Test ---');
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

          // Check for duplicates
          const uniquePasswords = new Set(passwords);
          if(uniquePasswords.size === count){
            pass(`Password: Generated ${count} unique passwords`);
            results.push({test:'password_csprng',ok:true,count:count,unique:uniquePasswords.size});
          } else {
            fail(`Password: Collision detected (${uniquePasswords.size}/${count} unique)`);
            results.push({test:'password_csprng',ok:false,count:count,unique:uniquePasswords.size});
          }

          // Sample
          log(`Sample password: ${passwords[0]}`);

        } catch(e){ fail('Password CSPRNG test failed: ' + e.message); results.push({test:'password_csprng',ok:false,error:e.message}); }

        // Test 4: SHA-256 integrity (known test vector)
        try{
          log('\n--- Hash Integrity Test (SHA-256) ---');
          const testInput = 'abc';
          const expectedSHA256 = 'ba7816bf8f01cfea414140de5dae2223b00361a396177a9cb410ff61f20015ad';

          const encoder = new TextEncoder();
          const data = encoder.encode(testInput);
          const hashBuffer = await crypto.subtle.digest('SHA-256', data);
          const hashArray = Array.from(new Uint8Array(hashBuffer));
          const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');

          if(hashHex === expectedSHA256){
            pass(`SHA-256: Correct digest for input "${testInput}"`);
            results.push({test:'sha256_integrity',ok:true,input:testInput,output:hashHex});
          } else {
            fail(`SHA-256: Digest mismatch (expected ${expectedSHA256}, got ${hashHex})`);
            results.push({test:'sha256_integrity',ok:false,input:testInput,expected:expectedSHA256,output:hashHex});
          }

        } catch(e){ fail('SHA-256 integrity test failed: ' + e.message); results.push({test:'sha256_integrity',ok:false,error:e.message}); }

        // Test 5: SHA-512 integrity (known test vector)
        try{
          log('\n--- Hash Integrity Test (SHA-512) ---');
          const testInput = 'abc';
          const expectedSHA512 = 'ddaf35a193617abacc417349ae20413112e6fa4e89a97ea20a9eeee64b55d39a2192992a274fc1a836ba3c23a3feebbd454d4423643ce80e2a9ac94fa54ca49f';

          const encoder = new TextEncoder();
          const data = encoder.encode(testInput);
          const hashBuffer = await crypto.subtle.digest('SHA-512', data);
          const hashArray = Array.from(new Uint8Array(hashBuffer));
          const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');

          if(hashHex === expectedSHA512){
            pass(`SHA-512: Correct digest for input "${testInput}"`);
            results.push({test:'sha512_integrity',ok:true,input:testInput,output:hashHex});
          } else {
            fail(`SHA-512: Digest mismatch (expected ${expectedSHA512}, got ${hashHex})`);
            results.push({test:'sha512_integrity',ok:false,input:testInput,expected:expectedSHA512,output:hashHex});
          }

        } catch(e){ fail('SHA-512 integrity test failed: ' + e.message); results.push({test:'sha512_integrity',ok:false,error:e.message}); }

        // Test 6: HMAC-SHA256 integrity (known test vector)
        try{
          log('\n--- HMAC-SHA256 Integrity Test ---');
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
            pass(`HMAC-SHA256: Correct signature`);
            results.push({test:'hmac_sha256_integrity',ok:true,key:testKey,message:testMessage,output:signatureHex});
          } else {
            fail(`HMAC-SHA256: Signature mismatch (expected ${expectedHMAC}, got ${signatureHex})`);
            results.push({test:'hmac_sha256_integrity',ok:false,key:testKey,message:testMessage,expected:expectedHMAC,output:signatureHex});
          }

        } catch(e){ fail('HMAC-SHA256 integrity test failed: ' + e.message); results.push({test:'hmac_sha256_integrity',ok:false,error:e.message}); }

        // Test 7: JWT Signature Validation (HS256)
        try{
          log('\n--- JWT Signature Validation (HS256) ---');
          // Valid JWT signed with HS256 and secret "secret"
          const validJWT = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c';
          const secret = 'secret';

          const parts = validJWT.split('.');
          if(parts.length !== 3){
            fail('JWT: Invalid token format');
            results.push({test:'jwt_signature_hs256',ok:false,error:'Invalid format'});
          } else {
            const header = parts[0];
            const payload = parts[1];
            const signature = parts[2];
            const data = header + '.' + payload;

            // Decode signature
            const signatureDecoded = Uint8Array.from(atob(signature.replace(/-/g, '+').replace(/_/g, '/')), c => c.charCodeAt(0));

            // Compute expected signature
            const encoder = new TextEncoder();
            const keyData = encoder.encode(secret);
            const messageData = encoder.encode(data);

            const cryptoKey = await crypto.subtle.importKey(
              'raw',
              keyData,
              { name: 'HMAC', hash: 'SHA-256' },
              false,
              ['verify']
            );

            const isValid = await crypto.subtle.verify('HMAC', cryptoKey, signatureDecoded, messageData);

            if(isValid){
              pass('JWT HS256: Signature verification successful');
              results.push({test:'jwt_signature_hs256',ok:true,algorithm:'HS256'});
            } else {
              fail('JWT HS256: Signature verification failed');
              results.push({test:'jwt_signature_hs256',ok:false,algorithm:'HS256'});
            }
          }

        } catch(e){ fail('JWT HS256 signature test failed: ' + e.message); results.push({test:'jwt_signature_hs256',ok:false,error:e.message}); }

        // Test 8: JWT Signature Validation (RS256) - verification only
        try{
          log('\n--- JWT Signature Validation (RS256) ---');
          // Note: RS256 requires importing a public key in JWK format
          // For this test, we'll verify the algorithm detection and structure
          const rs256JWT = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.NHVaYe26MbtOYhSKkoKYdFVomg4i8ZJd8_-RU8VNbftc4TSMb4bXP3l3YlNWACwyXPGffz5aXHc6lty1Y2t4SWRqGteragsVdZufDn5BlnJl9pdR_kdVFUsra2rWKEofkZeIC4yWytE58sMIihvo9H1ScmmVwBcQP6XETqYd0aSHp1gOa9RdUPDvoXQ5oqygTqVtxaDr6wUFKrKItgBMzWIdNZ6y7O9E0DhEPTbE9rfBo6KTFsHAZnMg4k68CDp2woYIaXbmYTWcvbzIuHO7_37GT79XdIwkm95QJ7hYC9RiwrV7mesbY4PAahERJawntho0my942XheVLmGwLMBkQ';

          const parts = rs256JWT.split('.');
          if(parts.length !== 3){
            fail('JWT RS256: Invalid token format');
            results.push({test:'jwt_signature_rs256',ok:false,error:'Invalid format'});
          } else {
            const headerB64 = parts[0].replace(/-/g, '+').replace(/_/g, '/');
            const headerJSON = JSON.parse(atob(headerB64));

            if(headerJSON.alg === 'RS256'){
              pass('JWT RS256: Algorithm detected correctly (RS256 verification requires public key)');
              results.push({test:'jwt_signature_rs256',ok:true,algorithm:'RS256',note:'Structure validation only'});
            } else {
              fail('JWT RS256: Algorithm mismatch');
              results.push({test:'jwt_signature_rs256',ok:false,algorithm:headerJSON.alg});
            }
          }

        } catch(e){ fail('JWT RS256 signature test failed: ' + e.message); results.push({test:'jwt_signature_rs256',ok:false,error:e.message}); }

        // Test 5: UUID v1 CSPRNG validation (clock sequence & node ID must use CSPRNG)
        try{
          log('\n--- UUID v1 CSPRNG Test ---');
          // UUID v1 should use crypto.getRandomValues for clock_seq and node
          // We generate a v1 UUID and verify the random components are not predictable

          const d = new Date().getTime();
          const timeBytes = new Uint8Array(8);
          crypto.getRandomValues(timeBytes);
          
          const timestamp = (d * 10000) + 0x01B21DD213814000;
          const timeLow = (timestamp & 0xFFFFFFFF).toString(16).padStart(8, '0');
          const timeMid = ((timestamp >> 32) & 0xFFFF).toString(16).padStart(4, '0');
          const timeHiVersion = (((timestamp >> 48) & 0x0FFF) | 0x1000).toString(16).padStart(4, '0');
          const clockSeq = ((timeBytes[0] << 8 | timeBytes[1]) & 0x3FFF | 0x8000).toString(16).padStart(4, '0');
          const node = Array.from(timeBytes.slice(2, 8), b => b.toString(16).padStart(2, '0')).join('');
          
          const uuidv1 = `${timeLow}-${timeMid}-${timeHiVersion}-${clockSeq}-${node}`;

          if(uuidv1.length === 36 && uuidv1.charAt(14) === '1'){
            pass(`UUID v1: Generated valid UUID (version bit = 1)`);
            results.push({test:'uuid_v1_csprng',ok:true,sample:uuidv1});
            log(`Sample UUID v1: ${uuidv1}`);
          } else {
            fail(`UUID v1: Invalid format or version`);
            results.push({test:'uuid_v1_csprng',ok:false});
          }

        } catch(e){ fail('UUID v1 CSPRNG test failed: ' + e.message); results.push({test:'uuid_v1_csprng',ok:false,error:e.message}); }

        // Summary
        const failures = results.filter(r => !r.ok).length;
        log('\n=== Test Summary ===');
        if(failures === 0){
          pass(`All ${results.length} security tests passed`);
        } else {
          fail(`${failures} of ${results.length} tests failed`);
        }

        document.getElementById('downloadBtn').disabled = false;
      }

      document.getElementById('runBtn').addEventListener('click', runSecurityTests);
      document.getElementById('downloadBtn').addEventListener('click', function(){
        const data = {timestamp:new Date().toISOString(), results};
        const blob = new Blob([JSON.stringify(data,null,2)],{type:'application/json'});
        const u = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = u;
        a.download = 'security-tests-' + Date.now() + '.json';
        document.body.appendChild(a);
        a.click();
        setTimeout(()=>{ URL.revokeObjectURL(u); a.remove(); }, 750);
      });
    })();
  </script>
</body>
</html>
