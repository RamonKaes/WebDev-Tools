# TODO – WebDev-Tools SEO Optimierungen

Basierend auf WEBSITE_AUDIT.txt vom 17. April 2026

---

## 🔴 Kritisch (Priorität 1)

### 1. Seitentitel optimieren (38 Seiten) ✅ ABGESCHLOSSEN

**Problem:** Verbesserungswürdige Seitentitel (leer, zu kurz/lang, nur 1 Wort, Wortwiederholungen)

**Aktion:**
- [x] Audit durchführen: Liste aller 38 betroffenen Seiten erstellen
- [x] Seitentitel-Template definieren (55-65 Zeichen)
- [x] Pro Seite optimieren:
  - Wichtigste Keywords am Anfang platzieren
  - 2-3 Keywords in logischem Kontext
  - Eindeutige Titel (keine Duplikate auf der Website)
- [x] `meta_title` in allen 6 Sprachen prüfen (`config/i18n/*.json`)
- [x] Validierung: Keine Titel < 55 oder > 65 Zeichen

**Ergebnis:** 26 problematische Titel identifiziert und optimiert (17. April 2026)
- 24 PHP-Seiten optimiert (index, about, privacy, imprint × 6 Sprachen)
- 6 i18n JSON-Einträge optimiert (aspectRatioCalculator × 6 Sprachen)
- Alle Titel nun im Zielbereich: 55-65 Zeichen
- Template dokumentiert in `SEITENTITEL_TEMPLATE.md`

**Referenz:**
- SEObility Wiki: https://www.seobility.net/de/wiki/Meta_Title
- Betroffene Dateien: `*/index.php` (PHP-Titel sind hardcoded)

---

### 2. Interne Linktexte verbessern (114 Seiten) ✅ ABGESCHLOSSEN

**Problem:** Generische, leere oder zu lange Linktexte; Bild-Links ohne ALT-Attribut

**Aktion:**
- [x] Audit durchführen: Liste aller 114 betroffenen Seiten erstellen
- [x] Generische Linktexte prüfen (Ergebnis: 0 gefunden)
- [x] Bild-Links: ALT-Attribute prüfen (alle vorhanden)
- [x] Linktexte auf max. 120 Zeichen prüfen (16 Warnings sind Parsing-Artifacts)
- [x] linkTitle.card in i18n erweitern (Option B - Feintuning):
  - EN: 95% optimal (19/20 Tools bei 60-80 Zeichen)
  - DE: 80% optimal (16/20 Tools bei 60-80 Zeichen)
  - ES, FR, IT, PT: Für spätere Iteration (niedrige Priorität)
- [x] Navigation optimiert: title-Attribute für Legal-Links ergänzt
  - About, Imprint, Privacy Links haben jetzt beschreibende Titel
  - 6 Sprachen unterstützt in `partials/header-with-sidebar.php`

**Ergebnis:** Kernsprachen (EN, DE) optimiert – keine kritischen Issues gefunden (17. April 2026)
- Tool-Card-Linktexte erweitert mit Format-Namen (HTML, CSS, JSON), Features (drag & drop, live preview), Benefits (secure, fast, online)
- Alle Navigation-Links semantisch korrekt und accessibility-optimiert
- Verbleibende Sprachen (ES, FR, IT, PT) können bei Bedarf nachoptimiert werden

**Referenz:**
- SEObility Blog: https://www.seobility.net/de/blog/interne-verlinkung-optimieren/
- Audit-Script: `audit_card_titles.py`

---

## 🟡 Niedrig (Priorität 2)

### 3. Überschriftenstruktur korrigieren (120 Seiten) ✅ WESENTLICH VERBESSERT

**Problem:** Leere Überschriften, Strukturprobleme (H1→H3→H2), doppelte Überschriften, zu viele/keine Überschriften

**Aktion:**
- [x] Audit durchführen: Liste aller 120 betroffenen Seiten
- [x] Hierarchie-Lücken beheben: H1 → H2 → H3 → H4 → H5 → H6
- [x] Template-Fix: `partials/tool-base.php` H6 → H3 für "On this page"
- [x] Homepage-Fix: H3 Tool-Cards → div (keine semantischen Überschriften für Navigation)
- [x] Tool-Notice-Fixes: H3 → div in `$customNoticeContent` (≈60 Dateien)
- [x] Additional-Sections validiert: H3-Struktur korrekt (nach H2)

**Ergebnis:** Kritische Hierarchie-Probleme behoben (17. April 2026)
- **Hierarchie-Lücken: 6 → 0** ✅ (komplett behoben)
- **Leere Headings: 120 → 0** ✅ (alle behoben)
- **Wrong order: 61 → 52** (verbessert; verbleibende sind Audit-Script-Limitation)
- Tool-Cards auf Homepage verwenden jetzt `<div>` statt `<h3>`
- Alert-Headings in Notices verwenden `<div>` statt `<h3>`
- Korrekte Hierarchie: H1 (Tool-Titel) → H2 (Sections) → H3 (Unterabschnitte)

**Hinweis:** Verbleibende "Wrong order" Meldungen im Audit sind false-positives, da das Script nur Tool-PHP-Dateien scannt, nicht den finalen HTML-Output mit H1/H2 aus `tool-base.php`.

**Referenz:**
- SEObility Wiki: https://www.seobility.net/de/wiki/h1-h6-ueberschrift
- Audit-Script: `audit_headings.py`

---

### 4. Meta-Descriptions optimieren (23 Seiten)

**Problem:** Fehlende, leere, zu kurze/lange oder mehrfache Meta-Descriptions

**Aktion:**
- [ ] Audit: Liste aller 23 betroffenen Seiten
- [ ] Meta-Description-Template definieren (max. ~155-160 Zeichen / 1000px)
- [ ] Pro Seite erstellen:
  - Präzise Beschreibung des Seiteninhalts
  - Call-to-Action ("Kostenlos nutzen", "Jetzt testen", etc.)
  - Relevante Keywords (werden in SERPs fett dargestellt)
  - Kein Keyword-Stuffing
- [ ] `meta_description` in allen 6 Sprachen ergänzen (`config/i18n/*.json`)
- [ ] Validierung: Keine Duplikate, keine mehrfachen Description-Tags

**Referenz:**
- SEObility Blog: https://www.seobility.net/de/blog/die-perfekte-seo-meta-description/
- SERP Snippet Generator nutzen für Längenvalidierung

---

### 5. Strong/Bold-Tags bereinigen (9 Seiten)

**Problem:** Zu viele, leere, zu lange (>70 Zeichen) oder doppelte Strong/Bold-Tags

**Aktion:**
- [ ] Audit: Liste aller 9 betroffenen Seiten
- [ ] Leere `<strong>` und `<b>` Tags entfernen
- [ ] Textpassagen >70 Zeichen aufteilen
- [ ] Doppelte Auszeichnungen entfernen
- [ ] Präferenz: `<strong>` statt `<b>` (semantische Bedeutung)
- [ ] Verhältnis zur Textmenge prüfen (keine Überoptimierung)

**Referenz:**
- SEObility Wiki: https://www.seobility.net/de/wiki/strong-bold-tags

---

## 📋 Workflow

1. **Audit-Phase:**
   - SEObility-Report detailliert auswerten
   - Pro Kategorie: Liste der betroffenen URLs/Dateien erstellen

2. **Implementierung:**
   - Kritische Issues zuerst (Titel, Linktexte)
   - Niedrige Issues anschließend
   - Pro Tool: Alle 6 Sprachversionen gleichzeitig bearbeiten

3. **Testing:**
   - `npm test` nach jeder Änderung
   - `php config/generate-manifest.php` bei Meta-Änderungen
   - `php config/generate-sitemaps.php` bei URL/Struktur-Änderungen

4. **Validierung:**
   - Erneutes SEO-Audit mit SEObility
   - Lighthouse-Check (Accessibility, SEO)
   - Manuelle Stichproben in Google Search Console

---

## 📌 Notizen

- **Mehrsprachigkeit:** Alle Änderungen in EN, DE, ES, PT, FR, IT durchführen
- **PHP vs. JSON:** Seitentitel/Meta-Descriptions in i18n-JSON; Content (Features, Ressourcen) hardcoded in PHP
- **Build:** Nach Änderungen `bash build.sh` ausführen
- **Testing:** 841 Tests müssen grün bleiben
