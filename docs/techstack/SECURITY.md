# Security – WebDev-Tools

**Privacy-First-Architektur und Sicherheitsregeln** für die Tool-Entwicklung. Alles hier Beschriebene steht so im Code; Quelldateien sind jeweils genannt.

---

## Prinzipien

**Alle sensiblen Daten bleiben im Browser.**

- Kein Backend-Processing von User-Daten: PHP rendert nur Seiten, Tools laufen komplett in JavaScript
- Kein Analytics, kein Tracking, keine Third-Party-Cookies
- Einziges Cookie: `webdev-tools-lang` (Sprachwahl, `SameSite=Strict`, 30 Tage, gesetzt von `config/language-handler.php`)
- Externe Ressourcen: nur zwei Scripts von `cdn.jsdelivr.net`, beide mit SRI-Hash – `qrcode-generator@1.4.4` (QR-Tool, `config/tools.php`) und `terser@5.31.0` (Code-Formatter, erst beim ersten Minify nachgeladen). Bootstrap, Bootstrap Icons und Fonts sind selbst gehostet
- Dependabot und CodeQL laufen wöchentlich (`.github/dependabot.yml`, `.github/workflows/codeql.yml`)

---

## HTTP-Header (`config/security-headers.php`)

Wird von `partials/tool-base.php` direkt nach `config.php` eingebunden.

### Content Security Policy

Pro Request ein Nonce aus `random_bytes(16)`:

```
default-src 'self';
script-src 'self' 'nonce-{nonce}' https://cdn.jsdelivr.net;
style-src 'self';
font-src 'self';
img-src 'self' data: blob: https:;
connect-src 'self' https:;
object-src 'none'; media-src 'none'; worker-src 'self'; manifest-src 'self';
upgrade-insecure-requests;          (nur bei HTTPS)
frame-ancestors 'none'; base-uri 'self'; form-action 'self'
```

| Direktive | Grund |
|-----------|-------|
| `script-src 'self' 'nonce-…' https://cdn.jsdelivr.net` | Selbst gehostete Scripts über `'self'`, die wenigen Inline-Scripts in den Partials über `nonce="<?= getCspNonce() ?>"`, jsDelivr nur für die zwei SRI-gepinnten Bibliotheken. Kein `unsafe-eval` |
| `style-src 'self'`, `font-src 'self'` | Keine externen Styles/Fonts, keine Inline-Styles |
| `img-src … data: blob: https:` | Data-URLs (Base64-Tool, QR-Code), Blob-Downloads |
| `connect-src 'self' https:` | Der SRI-Generator lädt beliebige Ressourcen-URLs per `fetch()` |
| `frame-ancestors 'none'` | Clickjacking-Schutz; `X-Frame-Options: DENY` als Äquivalent für ältere Browser |

Für Tool-Entwickler heißt das: **kein Inline-JS außerhalb der IIFE-Datei**, keine `onclick`-Attribute, keine `style`-Attribute mit User-Daten, keine neuen CDN-Quellen ohne CSP-Änderung und SRI-Hash.

### Weitere Header

```
X-Frame-Options: DENY
X-Content-Type-Options: nosniff
X-XSS-Protection: 1; mode=block
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=(), usb=(), magnetometer=(), gyroscope=(), accelerometer=()
Strict-Transport-Security: max-age=31536000; includeSubDomains; preload   (nur bei HTTPS, auch hinter Proxy via X-Forwarded-Proto)
Cache-Control: no-cache, must-revalidate, private   (HTML-Seiten)
```

`.htaccess.production` erzwingt zusätzlich HTTPS per Redirect und entfernt `X-Powered-By` und `Server`.

---

## XSS-Prävention

### PHP

Jede Ausgabe von User-Input, Übersetzungen oder Konfigurationswerten läuft durch `htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')`. Eine kürzere Helper-Funktion gibt es nicht. JSON für Inline-Scripts wird mit `json_encode(…, JSON_HEX_TAG | JSON_HEX_AMP)` ausgegeben (`partials/head.php`).

Rohes HTML ist nur an definierten Stellen erlaubt und kommt ausschließlich aus dem PHP-Quelltext der Seite, nie aus Requests: `content` in `$additionalSections`, `$customNoticeContent`.

### JavaScript

```javascript
// Falsch
output.innerHTML = userInput;
container.innerHTML = `<div>${userInput}</div>`;

// Richtig
output.textContent = userInput;

// Muss User-Text doch in ein Template: vorher escapen
container.innerHTML = `<div>${window.AppHelpers.escapeHtml(userInput)}</div>`;
```

- `innerHTML` nur für Markup aus eigenen Template-Strings mit i18n-Strings; alles aus Eingabefeldern, Dateien oder URLs über `textContent` oder `AppHelpers.escapeHtml()` (`assets/js/helpers.js`)
- Kein `eval()`, `new Function()`, `document.write()`, `document.execCommand()`; Event-Handler per `addEventListener`
- `tool-loader.js` escaped die Tool-ID, bevor sie in Fehlermeldungen landet
- Die ESLint-Konfiguration (`eslint.config.js`) verbietet `var` und erzwingt `prefer-const`; `npm run lint` läuft in CI

### Downloads und Dateinamen

`DownloadUtils.sanitizeFilename()` entfernt Pfadtrenner und Steuerzeichen, `getValidatedMimeType()` lässt nur bekannte MIME-Typen zu (`assets/js/lib/download-utils.js`). Dateien, die ein Tool per Drag & Drop oder Datei-Dialog liest, werden mit `FileReader` im Browser verarbeitet und nie hochgeladen.

---

## Sensible Daten in Tools

- **Zufall**: ausschließlich `crypto.getRandomValues()` / `crypto.randomUUID()`; nie `Math.random()` für Passwörter, UUIDs oder Tokens
- **Hashes/SRI**: `crypto.subtle.digest()`; Eingaben werden weder geloggt noch gespeichert
- **Passwörter, Hashes, JWTs**: nur im DOM anzeigen, kein `localStorage`, keine URL-Parameter, kein `console.log` mit Nutzdaten
- **JWT-Decoder**: dekodiert nur Header, Payload und Signatur-Teil, verifiziert keine Signatur
- Was in `localStorage` liegt: Theme, Sprache, Sidebar-Zustand, der gecachte `config/manifest.json` – keine Nutzdaten

---

## Server und Betrieb

- HTTPS erzwungen (`.htaccess.production`), HSTS mit Preload-Flag
- Deploy nur aus einem sauberen `main`-Checkout; `build-tools/check-deploy.sh` verweigert Builds mit Backup-, Log-, `.env`- oder nicht versionierten Dateien in `dist/`
- FTP-Passwort kommt aus dem System-Keyring (`secret-tool`), nie aus Dateien oder Argumenten; Übertragung per FTPS mit Zertifikatsprüfung (`build-tools/deploy-ftp.sh`)
- `node_modules/`, Tests und Build-Tools werden nicht deployt – nur `dist/`
- Browser-Tests lassen jeden Test fehlschlagen, der einen CSP-Verstoß in der Konsole erzeugt (`tests/browser/fixtures.js`)
- `npm audit` vor jedem Release

---

## Checkliste für neue Tools

- [ ] `declare(strict_types=1)` in jeder PHP-Datei, `htmlspecialchars()` für jede Ausgabe
- [ ] `textContent` für alles aus User-Input; `innerHTML` nur mit eigenen Templates
- [ ] Kein Inline-JS, kein `eval`, kein `execCommand`, kein `var`
- [ ] Keine neue externe Quelle; falls unvermeidbar: SRI-Hash, Eintrag in `externalLibraries` oder Lazy-Load mit `integrity`, CSP anpassen
- [ ] Kryptografisch sicherer Zufall, keine Nutzdaten in Logs oder `localStorage`
- [ ] Fehlerfall-Tests mit XSS-Payloads (`<script>alert(1)</script>`, `<img src=x onerror=alert(1)>`) und sehr großen Eingaben
- [ ] `npm run lint`, `npm test`, `npm run test:browser` grün

---

## Meldungen

Sicherheitslücken bitte vertraulich über GitHub Private Vulnerability Reporting melden, siehe [SECURITY.md](../../SECURITY.md) im Repository-Root.

**Externe Checks:** [Mozilla Observatory](https://observatory.mozilla.org/), [securityheaders.com](https://securityheaders.com/), [SSL Labs](https://www.ssllabs.com/ssltest/), [OWASP Top 10](https://owasp.org/www-project-top-ten/), [MDN Web Security](https://developer.mozilla.org/en-US/docs/Web/Security), [content-security-policy.com](https://content-security-policy.com/)

**Siehe auch:** [BACKEND.md](BACKEND.md) (Header-Details), [NEUES-TOOL.md](NEUES-TOOL.md) (Code-Muster)
