Führe einen vollständigen Security-Review für das WebDev-Tools Projekt durch.

## Kontext
Privacy-First Developer Toolbox. Alle sensiblen Operationen laufen **client-side im Browser**. Kein Server-State. CSP ist aktiv.

## Scope

Analysiere systematisch:
- `*/index.php` (alle Tool-Seiten)
- `partials/tool-base.php`
- `config/*.php`
- `assets/js/tools/*.js`
- `assets/js/lib/*.js`

## Prüfkriterien (OWASP Top 10)

### PHP
- **XSS (A03):** `htmlspecialchars()` bei jeder Ausgabe von URL-Parametern oder User-Input?
- **Injection (A03):** `eval()`, `exec()`, unsichere String-Konkatenation?
- **Sec-Misconfig (A05):** `declare(strict_types=1)` in jeder Datei? Fehlerreporting korrekt?
- **Path Traversal (A01):** `include`/`require`-Pfade aus User-Input gebaut?
- **Sensitive Data (A02):** Sensible Daten geloggt oder in Sessions gespeichert?

### JavaScript
- **XSS (A03):** `innerHTML` mit unkontrollierten Daten statt `textContent`?
- **Sensitive Data (A02):** Verlassen Passwörter, Hashes oder Tokens den Browser?
- **eval (A03):** `eval()`, `new Function()`, `setTimeout(string)` vorhanden?
- **Prototype Pollution (A08):** Unsichere Merge-Operationen mit User-Input?

## Ausgabe pro Fund

```
📍 Datei: path/to/file (Zeile X)
🔴/🟡/🟢 Schweregrad: Kritisch / Mittel / Niedrig
❌ Problem: [Beschreibung]
✅ Fix: [konkreter Code-Vorschlag]
```

Am Ende: Zusammenfassung mit Anzahl der Funde pro Schweregrad und Liste der geprüften Dateien.
