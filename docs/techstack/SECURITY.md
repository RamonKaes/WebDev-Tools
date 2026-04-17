# Security – WebDev-Tools

**Sicherheits-Best Practices & Privacy-First-Architektur** – Detaillierte Checkliste für sichere Tool-Entwicklung.

---

## Security-Prinzipien

### 1. Privacy-First Architecture

**Grundsatz:** Alle sensiblen Daten bleiben im Browser.

**Umsetzung:**
- ✅ Kein Backend-Processing für User-Daten
- ✅ Kein Analytics-Tracking (Google Analytics, Matomo, etc.)
- ✅ Keine Third-Party-Cookies
- ✅ Kein Server-Side-Logging von User-Input
- ✅ Kein CloudFlare-Proxy (direkte Verbindung zum Server)

**Technische Maßnahmen:**
```php
// Keine User-Daten in Logs
error_reporting(E_ALL & ~E_NOTICE & ~E_USER_NOTICE);

// Keine Session-Cookies (außer für Admin-Bereich, falls vorhanden)
ini_set('session.use_cookies', '0');
```

---

### 2. Content Security Policy (CSP)

**Header (`config/security-headers.php`):**
```php
$cspNonce = base64_encode(random_bytes(16));
header("Content-Security-Policy: " .
  "default-src 'self'; " .
  "script-src 'self' 'nonce-{$cspNonce}' https://cdn.jsdelivr.net https://www.googletagmanager.com; " .
  "style-src 'self' https://cdn.jsdelivr.net; " .
  "img-src 'self' data: blob: https:; " .
  "font-src 'self' https://cdn.jsdelivr.net; " .
  "connect-src 'self' https:; " .
  "frame-ancestors 'none'; " .
  "base-uri 'self'; " .
  "form-action 'self'"
);
```

**Wichtige Direktiven:**

| Direktive | Wert | Zweck |
|-----------|------|-------|
| `default-src` | `'self'` | Nur Ressourcen von eigener Domain |
| `script-src` | `'self' 'nonce-...'` | Nonce-basiert, kein unsafe-inline |
| `frame-ancestors` | `'none'` | Clickjacking-Schutz |
| `connect-src` | `'self' https:` | HTTPS-Requests erlaubt (z. B. SRI URL-Fetch) |

**Nonce-basierte CSP:**
- Jeder Request generiert einen kryptografischen Nonce via `random_bytes(16)`
- Alle `<script>`-Tags müssen `nonce="..."` enthalten
- Kein `'unsafe-inline'` nötig – sicherer als erlaubt

---

### 3. Additional Security Headers

```php
// X-Content-Type-Options
header("X-Content-Type-Options: nosniff");

// X-Frame-Options (Clickjacking-Schutz)
header("X-Frame-Options: DENY");

// Referrer-Policy
header("Referrer-Policy: strict-origin-when-cross-origin");

// Permissions-Policy (Feature-Policy)
header("Permissions-Policy: geolocation=(), microphone=(), camera=()");

// Strict-Transport-Security (HSTS)
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
```

**HSTS Preload:**
- Domain in Chrome HSTS Preload List eintragen
- Submission: https://hstspreload.org/
- **Vorsicht:** Nicht rückgängig zu machen (ohne Wartezeit)

---

## XSS-Prevention

### PHP-Seite (Server-Side)

**IMMER `htmlspecialchars()` für User-Input:**

```php
// ❌ FALSCH
echo $_GET['name'];
echo $userInput;

// ✅ RICHTIG
echo htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8');
echo esc($userInput);  // Helper-Funktion (config/helpers.php)
```

**Helper-Funktion:**
```php
function esc(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
```

**Context-Aware Escaping:**
```php
// HTML-Context
echo esc($str);

// Attribute-Context
echo '<div data-value="' . esc($str) . '">';

// JavaScript-Context
echo '<script>const name = ' . json_encode($str) . ';</script>';

// URL-Context
echo '<a href="' . urlencode($str) . '">';
```

---

### JavaScript (Client-Side)

**NIEMALS `innerHTML` mit User-Input:**

```javascript
// ❌ FALSCH
element.innerHTML = userInput;
element.insertAdjacentHTML('beforeend', userInput);
document.write(userInput);

// ✅ RICHTIG
element.textContent = userInput;
element.innerText = userInput;  // Alternative (berücksichtigt CSS-Hiding)

// Für HTML-Content: DOMPurify nutzen
element.innerHTML = DOMPurify.sanitize(userInput);
```

**Event-Handler:**
```javascript
// ❌ FALSCH
element.setAttribute('onclick', userInput);
element.onclick = new Function(userInput);

// ✅ RICHTIG
element.addEventListener('click', () => {
  // Safe handler
});
```

**Template-Strings:**
```javascript
// ❌ FALSCH (bei User-Input)
container.innerHTML = `<div>${userInput}</div>`;

// ✅ RICHTIG
const div = document.createElement('div');
div.textContent = userInput;
container.appendChild(div);

// ODER: Helper-Funktion
function escapeHTML(str) {
  const div = document.createElement('div');
  div.textContent = str;
  return div.innerHTML;
}

container.innerHTML = `<div>${escapeHTML(userInput)}</div>`;
```

---

## Input Validation

### Client-Side Validation

**Validators (`assets/js/lib/validators.js`):**

```javascript
window.Validators = {
  isValidJSON: function(str) {
    try {
      JSON.parse(str);
      return true;
    } catch {
      return false;
    }
  },

  isValidURL: function(str) {
    try {
      new URL(str);
      return true;
    } catch {
      return false;
    }
  },

  isValidEmail: function(str) {
    // Einfache Regex (RFC-compliant ist komplex)
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(str);
  },

  isValidHex: function(str) {
    return /^[0-9A-Fa-f]+$/.test(str);
  },

  sanitizeInput: function(str, maxLength = 1000000) {
    // Längen-Check
    if (str.length > maxLength) {
      throw new Error('Input too long');
    }

    // Null-Bytes entfernen (Security)
    return str.replace(/\0/g, '');
  }
};
```

**Verwendung:**
```javascript
function processInput() {
  const input = document.getElementById('input').value;

  // Validation
  if (!window.Validators.isValidJSON(input)) {
    showError(t('tools.jsonFormatter.invalidJson'));
    return;
  }

  // Sanitization
  const sanitized = window.Validators.sanitizeInput(input);

  // Processing
  const result = JSON.parse(sanitized);
  displayResult(result);
}
```

---

### Server-Side Validation (PHP)

**Auch wenn Client-Side validiert wird, IMMER Server-Side prüfen:**

```php
// Type-Check via strict_types
declare(strict_types=1);

function processData(string $input): string {
    // Längen-Check
    if (strlen($input) > 1000000) {
        throw new InvalidArgumentException('Input too long');
    }

    // Null-Bytes entfernen
    $input = str_replace("\0", '', $input);

    // Format-Validation
    if (!isValidFormat($input)) {
        throw new InvalidArgumentException('Invalid format');
    }

    return $input;
}
```

---

## File Upload Security

### Client-Side (Drag & Drop)

**DragDropUtils (`assets/js/lib/dragdrop-utils.js`):**

```javascript
window.DragDropUtils = {
  init: function(dropZone, onSuccess, onError, options = {}) {
    const maxSizeMB = options.maxSizeMB || 10;
    const acceptedTypes = options.acceptedTypes || [];

    dropZone.addEventListener('drop', (e) => {
      e.preventDefault();
      const file = e.dataTransfer.files[0];

      // File-Size-Check
      if (file.size > maxSizeMB * 1024 * 1024) {
        onError(new Error(`File too large (max ${maxSizeMB} MB)`));
        return;
      }

      // File-Type-Check
      if (acceptedTypes.length > 0) {
        const ext = '.' + file.name.split('.').pop().toLowerCase();
        if (!acceptedTypes.includes(ext)) {
          onError(new Error(`File type not allowed (${ext})`));
          return;
        }
      }

      // File-Content-Read
      const reader = new FileReader();
      reader.onload = (e) => {
        // Content-Validation (z.B. JSON)
        if (acceptedTypes.includes('.json')) {
          try {
            JSON.parse(e.target.result);
          } catch {
            onError(new Error('Invalid JSON file'));
            return;
          }
        }

        onSuccess(file, e.target.result);
      };
      reader.onerror = () => onError(new Error('File read failed'));
      reader.readAsText(file);
    });
  }
};
```

**Wichtig:**
- Datei bleibt im Browser (kein Upload zum Server)
- Content-Validation vor Verarbeitung
- Error-Handling für korrupte Dateien

---

## Sensitive Data Handling

### Passwords & Hashes

**Password-Generator-Tool:**
```javascript
function generatePassword(length, options) {
  // Password-Generierung (crypto.getRandomValues)
  const password = /* ... */;

  // ❌ NIEMALS:
  // - Password in localStorage speichern
  // - Password via URL-Parameter weitergeben
  // - Password in Console loggen (außer Debug)

  // ✅ RICHTIG:
  // - Nur im DOM anzeigen (textContent)
  // - ClipboardUtils für Copy (ephemeral)
  // - Nach Copy optional: Password aus DOM löschen

  return password;
}
```

**Hash-Generator-Tool:**
```javascript
async function generateHash(input, algorithm) {
  // Hash berechnen (SubtleCrypto API)
  const hash = await crypto.subtle.digest(algorithm, encoder.encode(input));

  // ❌ NIEMALS:
  // - Input (Plaintext) loggen oder speichern
  // - Hash via unencrypted Connection senden

  // ✅ RICHTIG:
  // - Hash nur anzeigen
  // - Input nach Hashing aus Memory löschen (GC)

  return hash;
}
```

---

### JWT-Decoder

**Sicherheits-Hinweise im Tool:**

```javascript
function decodeJWT(token) {
  // JWT parsen (client-side)
  const decoded = /* ... */;

  // ⚠️ WARNING:
  // - JWT kann sensible Daten enthalten
  // - Kein Server-Side-Verification (nur Decoding)
  // - Signature-Verification nicht möglich ohne Secret

  // Notice anzeigen
  showNotice(
    'This tool only decodes JWTs. It does NOT verify signatures. ' +
    'Never paste production tokens into online tools.',
    'warning'
  );

  return decoded;
}
```

---

## HTTPS & TLS

### Erzwingen von HTTPS

**.htaccess:**
```apache
# HTTPS-Redirect
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
```

**HSTS-Header:**
```php
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
```

---

### TLS-Konfiguration (Server)

**Nginx-Beispiel:**
```nginx
ssl_protocols TLSv1.2 TLSv1.3;
ssl_ciphers 'ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:...';
ssl_prefer_server_ciphers on;

# OCSP Stapling
ssl_stapling on;
ssl_stapling_verify on;
```

**Apache-Beispiel:**
```apache
SSLProtocol -all +TLSv1.2 +TLSv1.3
SSLCipherSuite HIGH:!aNULL:!MD5
SSLHonorCipherOrder on
```

---

## Dependency Security

### npm audit

**Regelmäßige Checks:**
```bash
# Vulnerabilities prüfen
npm audit

# Auto-Fix (kompatible Updates)
npm audit fix

# Force-Fix (Breaking Changes möglich)
npm audit fix --force
```

**Workflow bei Vulnerabilities:**
1. Issue im Repo erstellen mit `npm audit` Output
2. Severity bewerten (Critical > High > Moderate > Low)
3. Update-Path prüfen (Breaking Changes?)
4. Tests nach Update ausführen
5. Deploy nur nach grünen Tests

---

### GitHub Dependabot

**Auto-PRs für Security-Updates:**

```yaml
# .github/dependabot.yml
version: 2
updates:
  - package-ecosystem: "npm"
    directory: "/"
    schedule:
      interval: "daily"  # Täglich für Security-Updates
    open-pull-requests-limit: 10
```

**Review-Prozess:**
1. Dependabot erstellt PR
2. CI-Tests laufen automatisch
3. Bei grün: Merge
4. Bei rot: Manuelles Debugging

---

## API Security (falls zukünftig benötigt)

### Rate Limiting

**Aktuell:** Nicht benötigt (kein Backend-Processing)

**Falls zukünftig API:**
```php
// PHP-Rate-Limiting (Beispiel)
function checkRateLimit(string $ip): bool {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    
    $key = "rate_limit:$ip";
    $requests = $redis->incr($key);
    
    if ($requests === 1) {
        $redis->expire($key, 60);  // 60 Sekunden Window
    }
    
    return $requests <= 100;  // Max 100 Requests/Minute
}

if (!checkRateLimit($_SERVER['REMOTE_ADDR'])) {
    http_response_code(429);
    die('Rate limit exceeded');
}
```

---

### CORS Policy

**Aktuell:** Nicht relevant (keine Cross-Origin-Requests)

**Falls zukünftig API:**
```php
// Strikt: Nur eigene Domain
header("Access-Control-Allow-Origin: https://webdev-tools.info");

// Oder: Whitelist
$allowedOrigins = ['https://example.com', 'https://trusted-partner.com'];
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if (in_array($origin, $allowedOrigins, true)) {
    header("Access-Control-Allow-Origin: $origin");
}

// NIEMALS:
// header("Access-Control-Allow-Origin: *");  // Zu permissiv!
```

---

## Privacy Compliance

### GDPR / DSGVO

**Aktuell umgesetzt:**
- ✅ Keine Cookies (außer technisch notwendige)
- ✅ Kein Tracking
- ✅ Keine User-Daten auf Server
- ✅ Privacy-Policy vorhanden (`privacy.php`)
- ✅ Imprint vorhanden (`imprint.php`)

**Technisch notwendige Cookies (falls vorhanden):**
- Language-Preference (optional)
- Dark-Mode-Preference (optional)

**Cookie-Banner:** Aktuell nicht benötigt (keine Tracking-Cookies)

---

### Data Minimization

**Prinzip:** Nur sammeln, was absolut nötig ist.

**Server-Logs:**
```apache
# Apache: Log-Format reduzieren
LogFormat "%h %t \"%r\" %>s %b" minimal
CustomLog /var/log/apache2/access.log minimal

# Oder: Logs deaktivieren (nur Error-Logs)
# CustomLog /dev/null combined
```

**Nginx:**
```nginx
access_log off;
error_log /var/log/nginx/error.log warn;
```

---

## Security Checklist (für neue Tools)

### Code-Review

- [ ] `declare(strict_types=1)` in jeder PHP-Datei
- [ ] `htmlspecialchars()` für alle User-Outputs
- [ ] `textContent` statt `innerHTML` für User-Inputs in JS
- [ ] Input-Validation (Client + Server)
- [ ] Keine sensiblen Daten in `console.log()`
- [ ] Keine `eval()` oder `new Function()`
- [ ] Keine `document.execCommand()` (deprecated)
- [ ] CSP-Header korrekt gesetzt
- [ ] HTTPS erzwungen (HSTS)

---

### Testing

- [ ] XSS-Tests (Payloads: `<script>alert(1)</script>`, `<img src=x onerror=alert(1)>`)
- [ ] SQL-Injection-Tests (falls DB-Zugriff): `' OR '1'='1`
- [ ] Path-Traversal-Tests: `../../etc/passwd`
- [ ] Large-Input-Tests (1 MB, 10 MB, 100 MB)
- [ ] Special-Chars-Tests: Null-Bytes, Unicode, Emojis

---

### Deployment

- [ ] `.htaccess` aktualisiert (HTTPS-Redirect, Security-Headers)
- [ ] `robots.txt` vorhanden (kein Crawling sensitiver Bereiche)
- [ ] Error-Pages (403, 404, 500) zeigen keine Stacktraces
- [ ] File-Permissions korrekt (644 für Dateien, 755 für Ordner)
- [ ] `.git/` nicht öffentlich zugänglich
- [ ] `node_modules/` nicht deployt (nur `dist/`)

---

## Incident Response

### Bei Security-Vorfall

**1. Sofort:**
- Betroffenes Tool offline nehmen (Maintenance-Mode)
- Vulnerability analysieren (Scope, Impact)
- Fix entwickeln & testen

**2. Innerhalb 24h:**
- Fix deployen
- Security-Advisory veröffentlichen (GitHub Security Advisories)
- Betroffene User informieren (falls identifizierbar)

**3. Post-Mortem:**
- Root-Cause-Analyse
- Lessons Learned dokumentieren
- Preventive Measures implementieren

**Kontakt:**
- Security-Issues: security@webdev-tools.info (falls vorhanden)
- Oder: GitHub Private Vulnerability Reporting

---

## Security-Resources

### Externe Tools

- **Mozilla Observatory:** https://observatory.mozilla.org/
- **Security Headers Check:** https://securityheaders.com/
- **SSL Labs Test:** https://www.ssllabs.com/ssltest/
- **OWASP Dependency-Check:** https://owasp.org/www-project-dependency-check/

### Best Practices

- **OWASP Top 10:** https://owasp.org/www-project-top-ten/
- **MDN Web Security:** https://developer.mozilla.org/en-US/docs/Web/Security
- **CSP Guide:** https://content-security-policy.com/

---

**Weitere Infos:**
- [DEPENDENCIES.md](DEPENDENCIES.md) – Dependency-Security
- [BACKEND.md](BACKEND.md) – PHP-Security-Standards
- [FRONTEND.md](FRONTEND.md) – JS-Security-Best Practices
