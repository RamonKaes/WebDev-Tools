# 🚀 Deployment-Anleitung

## Automatisches Deployment

Das Projekt enthält ein automatisches Deployment-Script:

```bash
./deploy.sh
```

Dies erstellt ein Paket `webdev-tools_TIMESTAMP.tar.gz` mit allen notwendigen Dateien.

### Deployment-Konfiguration

Das Script verwendet `.deployignore` um zu definieren, welche Dateien/Ordner **nicht** ins Production-Paket kommen:
- Development-Tools (dev/, tests/, bin/)
- Deployment-Scripts (deploy.sh, migrate-*.sh, migrate_*.py)
- Git-Dateien (.git/, .github/, .gitignore)
- Dokumentation (README.md, docs/, CONTRIBUTING.md)
- CI/CD und Editor-Konfiguration

## Was wird deployed?

### ✅ Enthalten:
- Alle PHP-Dateien (*.php)
- Assets (CSS, JS, Images, Fonts)
- Konfiguration (config/)
- Alle Tool-Verzeichnisse (19 Tools in 6 Sprachen)
- Sitemaps
- .htaccess (aus .htaccess.production)
- robots.txt, favicon.ico

### ❌ Nicht enthalten:
- Development-Tools (dev/, tests/, bin/)
- Git-Dateien (.git/, .gitignore)
- Dokumentation (README.md, docs/)
- Node/Composer Dependencies
- CI/CD Konfiguration (.github/)
- PHP CodeSniffer, EditorConfig

## Manuelle Installation auf dem Server

### Schritt 1: Upload
```bash
# Per SCP
scp webdev-tools_*.tar.gz user@server:/pfad/zum/webroot/

# Oder per FTP-Client (FileZilla, etc.)
```

### Schritt 2: Entpacken
```bash
ssh user@server
cd /pfad/zum/webroot/
tar -xzf webdev-tools_*.tar.gz
rm webdev-tools_*.tar.gz  # Optional: Archiv löschen
```

### Schritt 3: Berechtigungen
```bash
# Alle Dateien lesbar machen
chmod -R 644 *
chmod -R 755 */

# PHP-Dateien ausführbar
find . -name "*.php" -exec chmod 644 {} \;

# .htaccess schreibgeschützt
chmod 444 .htaccess
```

### Schritt 4: Webserver-Konfiguration

#### Apache
- Stelle sicher, dass `mod_rewrite` aktiviert ist
- AllowOverride muss auf `All` oder `FileInfo` stehen
- PHP 7.4+ erforderlich

#### Nginx
Falls du Nginx verwendest, konvertiere die .htaccess Regeln:
```nginx
location / {
    try_files $uri $uri/ /index.php?$args;
}

# URL Redirects für lokalisierte Versionen
location ~ ^/(es|fr|it|pt)/(password-generator|data-converter.*|emoji-reference|character-reference|code-formatter.*|string-escaper.*|px-to-rem-converter)/?$ {
    return 301 $scheme://$host/$1/<lokalisierter-slug>/;
}
```

## Was muss auf dem Server sein?

### Mindestanforderungen:
- ✅ PHP 7.4 oder höher
- ✅ Apache mit mod_rewrite ODER Nginx
- ✅ 10 MB freier Speicherplatz
- ✅ HTTPS (empfohlen für CSP)

### Nicht erforderlich:
- ❌ Datenbank
- ❌ Composer
- ❌ Node.js
- ❌ Schreibrechte (außer für Logs, falls aktiviert)

## Verzeichnisstruktur auf dem Server

```
webroot/
├── .htaccess              # URL Rewriting & Security Headers
├── index.php              # Hauptseite (EN)
├── robots.txt
├── sitemap.xml
├── sitemap-en.xml
├── 403.php, 404.php, 500.php
├── about.php, privacy.php, imprint.php
├── assets/
│   ├── css/
│   ├── js/
│   ├── img/
│   ├── data/
│   └── bootstrap/
├── config/
│   ├── config.php
│   ├── tools.php
│   ├── language-handler.php
│   ├── helpers.php
│   └── i18n/
│       ├── de.json
│       ├── en.json
│       ├── es.json
│       ├── fr.json
│       ├── it.json
│       └── pt.json
├── de/, es/, fr/, it/, pt/  # Lokalisierte Versionen
│   ├── index.php
│   ├── sitemap.xml
│   └── [tool-verzeichnisse]/
└── [18 Tool-Verzeichnisse]/
    └── index.php
```

## Deployment-Checkliste

- [ ] `./deploy.sh` ausgeführt
- [ ] Paket auf Server hochgeladen
- [ ] Archiv entpackt
- [ ] Berechtigungen gesetzt (644/755)
- [ ] .htaccess vorhanden und lesbar
- [ ] PHP-Version geprüft (php -v)
- [ ] Webserver Rewrite aktiviert
- [ ] Testaufruf: https://deine-domain.de/
- [ ] Testaufruf: https://deine-domain.de/de/
- [ ] Tool-Test: https://deine-domain.de/password-generator/
- [ ] Redirect-Test: https://deine-domain.de/es/password-generator/ → /es/generador-contrasenas/

## Troubleshooting

### 500 Internal Server Error
- Prüfe .htaccess Syntax
- Aktiviere mod_rewrite: `sudo a2enmod rewrite`
- Prüfe Apache Error Log: `tail -f /var/log/apache2/error.log`

### 404 Fehler bei Tools
- Prüfe ob mod_rewrite aktiv ist
- Prüfe AllowOverride Einstellung in Apache Config
- Teste direkt: https://domain.de/password-generator/index.php

### Styling fehlt
- Prüfe assets/ Verzeichnis ist komplett hochgeladen
- Prüfe Berechtigungen: `chmod -R 755 assets/`
- Prüfe Browser Console auf 404-Fehler

### Sprachen funktionieren nicht
- Prüfe config/i18n/ Verzeichnis existiert
- Prüfe JSON-Dateien sind gültig: `php -r "json_decode(file_get_contents('config/i18n/de.json'));"`
- Prüfe config/language-handler.php existiert

## Automatisches Deployment via CI/CD

Falls du automatisches Deployment einrichten möchtest:

### GitHub Actions (bereits vorbereitet in .github/workflows/ci.yml)
```yaml
- name: Deploy to Server
  run: |
    ./deploy.sh
    scp webdev-tools_*.tar.gz ${{ secrets.SSH_USER }}@${{ secrets.SSH_HOST }}:${{ secrets.DEPLOY_PATH }}
```

### FTP-Deploy
```bash
# Mit lftp
lftp -c "open -u $FTP_USER,$FTP_PASS $FTP_HOST; mirror -R deploy_package/ /public_html/"
```

## Rollback

Falls etwas schief geht:

1. **Backup wiederherstellen**:
   ```bash
   tar -xzf backup_vorheriges_datum.tar.gz
   ```

2. **Oder Git-Version neu deployen**:
   ```bash
   git checkout <commit-hash>
   ./deploy.sh
   # Upload und entpacken
   ```

## Support

Bei Problemen:
1. Prüfe Server Error Logs
2. Teste mit `/index.php` statt `/`
3. Prüfe PHP-Version: `php -v`
4. Öffne ein GitHub Issue mit Details

