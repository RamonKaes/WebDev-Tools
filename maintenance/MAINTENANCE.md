# Script Audit — .sh / .py / bin files

Status: Audit created as part of `chore/cleanup/remove-tests-and-deps` branch.

## Summary
Nach Entfernung aller Tests und Dev-Dependencies wurden die verbleibenden Shell- und Python-Skripte sowie Binärskripte geprüft. Dieses Dokument listet Zweck, Abhängigkeiten und meine Empfehlung (Behalten / Archivieren / Entfernen) für jedes Script.

---

## Files

### `bin/check`
- Typ: Bash script (executable)
- Zweck: Lightweight local checks (PHP syntax, PHPCS via PHAR) ohne Composer/Node
- Abhängigkeiten: PHP (CLI), curl (zum Herunterladen der phpcs.phar)
- Empfehlung: **Behalten** — wichtig für lokale sanity checks, und wird in README referenziert.
- Anmerkung: Lädt `phpcs.phar` on-demand; kein Composer nötig.

### `bin/verify-tools.sh`
- Typ: Bash script
- Zweck: Verifiziert, ob die Tools in den Sitemaps als Verzeichnisse mit `index.php` existieren (Sitemap vs. Dateien)
- Abhängigkeiten: grep, bash, coreutils
- Empfehlung: **Behalten** — hilfreiches Integrity-Tool für Content/SEO workflows.

### `dev/start-server.sh`
- Typ: Bash script
- Zweck: Hilft lokalen Entwicklern, mit `php -S` einen Dev-Server zu starten
- Abhängigkeiten: PHP CLI
- Empfehlung: **Behalten** — nützlich für lokale Entwicklung; low-risk.

### `migrate-i18n-keys.sh` (bash)
- Typ: Shell migration script
- Zweck: Massen-Änderung/Umbenennung von i18n Keys via `jq` (JSON manipulations)
- Abhängigkeiten: `jq` (CLI)
- Empfehlung: **Archivieren / Behalten als one-off** — nicht für den täglichen Gebrauch, aber als Migrations-Tool nützlich; verschiebe in `scripts/` oder dokumentiere als one-time migration.

### `migrate_i18n.py` (python)
- Typ: Python script
- Zweck: Migrate i18n JSON keys (ähnlich wie die bash-Variante)
- Abhängigkeiten: Python 3
- Empfehlung: **Behalten** — einfache, portable Alternative zu `jq`-Script; sinnvoll für Wiederverwendbarkeit.

### `dev/check_i18n_keys.py` (python)
- Typ: Python script
- Zweck: Vergleicht `config/i18n/en.json` mit anderen Übersetzungen -> listet missing/extra keys
- Abhängigkeiten: Python 3
- Empfehlung: **Behalten** — sehr nützlich zur Validierung von Übersetzungskonsistenz; empfehlenswert für i18n workflows.

### `migrate-i18n-keys.sh` vs `migrate_i18n.py`
- Beide erfüllen ähnliche Ziele; empfehle, **eine** als canonical migration tool zu behalten (vorzugsweise the Python version for portability) und die andere entweder zu archivieren oder in den Docs klar zu kennzeichnen.

**Aktuell:** Die legacy-Skripte wurden aus dem Repository entfernt und im Branch `archive/legacy-scripts` archiviert (Recovery möglich via Branch rollback).

---

## Empfehlungen & ToDos
- Behalte: `bin/check`, `bin/verify-tools.sh`, `dev/start-server.sh`, `migrate_i18n.py`, `dev/check_i18n_keys.py`.
- Archivieren: `migrate-i18n-keys.sh` (oder dokumentieren als legacy if you want to keep it).
- Dokumentation: Ergänze `README.md` oder `docs/` um eine kurze Sektion "Maintenance scripts" mit Verwendungs- und Abhängigkeits-Hinweisen (jq, python3, php, curl).
- Optional: Verschiebe alle maintenance scripts in `scripts/` oder `tools/maintenance/` um repo-root aufzuräumen und klar zu machen, dass diese nicht Teil des runtime stack sind.

---

Wenn du möchtest, übernehme ich die vorgeschlagenen Änderungen (z.B. verschieben/archivieren von `migrate-i18n-keys.sh` und Ergänzen der Dokumentation) und öffne dafür ein zusätzliches PR in `chore/cleanup/remove-tests-and-deps` (oder neuen Branch). Sag einfach welche Aktion du wünschst (z.B. "Archivieren" oder "Alles behalten und Dokumentation ergänzen").
