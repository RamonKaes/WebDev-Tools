#!/usr/bin/env python3
"""
Meta-Description Audit für WebDev-Tools
Prüft alle Seiten auf fehlende, leere, zu kurze/lange oder doppelte Meta-Descriptions
"""

import json
import os
from pathlib import Path
from collections import defaultdict

# Projektverzeichnis
BASE_DIR = Path(__file__).parent
I18N_DIR = BASE_DIR / "config" / "i18n"

# Meta-Description Richtlinien
MIN_LENGTH = 120  # Minimum für gute Descriptions
OPTIMAL_MIN = 140
OPTIMAL_MAX = 160
MAX_LENGTH = 200  # Hard maximum

# Sprachen
LANGUAGES = ['en', 'de', 'es', 'fr', 'it', 'pt']

def load_i18n(lang):
    """Lade i18n JSON für eine Sprache"""
    filepath = I18N_DIR / f"{lang}.json"
    if not filepath.exists():
        return {}
    
    with open(filepath, 'r', encoding='utf-8') as f:
        return json.load(f)

def check_meta_descriptions():
    """Prüfe alle Meta-Descriptions"""
    
    results = {
        'missing': defaultdict(list),      # Fehlende meta_description
        'empty': defaultdict(list),        # Leere meta_description
        'too_short': defaultdict(list),    # < MIN_LENGTH
        'too_long': defaultdict(list),     # > MAX_LENGTH
        'suboptimal': defaultdict(list),   # Nicht im OPTIMAL_MIN-OPTIMAL_MAX Bereich
        'duplicates': defaultdict(list),   # Doppelte Descriptions
        'optimal': defaultdict(list),      # Optimale Descriptions
    }
    
    for lang in LANGUAGES:
        data = load_i18n(lang)
        seo_data = data.get('seo', {})
        
        # Sammle alle Descriptions
        descriptions_seen = defaultdict(list)
        
        # 1. Homepage
        homepage_desc = seo_data.get('home', {}).get('meta_description', '')
        if not homepage_desc:
            results['missing'][lang].append('seo.home')
        elif homepage_desc.strip() == '':
            results['empty'][lang].append('seo.home')
        else:
            length = len(homepage_desc)
            descriptions_seen[homepage_desc].append('seo.home')
            
            if length < MIN_LENGTH:
                results['too_short'][lang].append(f"seo.home ({length} chars)")
            elif length > MAX_LENGTH:
                results['too_long'][lang].append(f"seo.home ({length} chars)")
            elif length < OPTIMAL_MIN or length > OPTIMAL_MAX:
                results['suboptimal'][lang].append(f"seo.home ({length} chars)")
            else:
                results['optimal'][lang].append(f"seo.home ({length} chars)")
        
        # 2. Statische Seiten (about, privacy, imprint)
        for page in ['about', 'privacy', 'imprint']:
            page_desc = seo_data.get(page, {}).get('meta_description', '')
            if not page_desc:
                results['missing'][lang].append(f"seo.{page}")
            elif page_desc.strip() == '':
                results['empty'][lang].append(f"seo.{page}")
            else:
                length = len(page_desc)
                descriptions_seen[page_desc].append(f"seo.{page}")
                
                if length < MIN_LENGTH:
                    results['too_short'][lang].append(f"seo.{page} ({length} chars)")
                elif length > MAX_LENGTH:
                    results['too_long'][lang].append(f"seo.{page} ({length} chars)")
                elif length < OPTIMAL_MIN or length > OPTIMAL_MAX:
                    results['suboptimal'][lang].append(f"seo.{page} ({length} chars)")
                else:
                    results['optimal'][lang].append(f"seo.{page} ({length} chars)")
        
        # 3. Tools (aus seo-Abschnitt)
        for tool_id, tool_info in seo_data.items():
            # Überspringe statische Seiten
            if tool_id in ['home', 'about', 'privacy', 'imprint']:
                continue
            
            tool_desc = tool_info.get('meta_description', '')
            if not tool_desc:
                results['missing'][lang].append(f"seo.{tool_id}")
            elif tool_desc.strip() == '':
                results['empty'][lang].append(f"seo.{tool_id}")
            else:
                length = len(tool_desc)
                descriptions_seen[tool_desc].append(f"seo.{tool_id}")
                
                if length < MIN_LENGTH:
                    results['too_short'][lang].append(f"seo.{tool_id} ({length} chars)")
                elif length > MAX_LENGTH:
                    results['too_long'][lang].append(f"seo.{tool_id} ({length} chars)")
                elif length < OPTIMAL_MIN or length > OPTIMAL_MAX:
                    results['suboptimal'][lang].append(f"seo.{tool_id} ({length} chars)")
                else:
                    results['optimal'][lang].append(f"seo.{tool_id} ({length} chars)")
        
        # Duplikate finden
        for desc, pages in descriptions_seen.items():
            if len(pages) > 1:
                results['duplicates'][lang].append(f"{desc[:50]}... used by: {', '.join(pages)}")
    
    return results

def print_report(results):
    """Drucke strukturierten Report"""
    
    print("=" * 80)
    print("META-DESCRIPTION AUDIT - WebDev-Tools")
    print("=" * 80)
    print()
    print(f"Richtlinien:")
    print(f"  • Minimum:  {MIN_LENGTH} Zeichen (darunter = zu kurz)")
    print(f"  • Optimal:  {OPTIMAL_MIN}-{OPTIMAL_MAX} Zeichen")
    print(f"  • Maximum:  {MAX_LENGTH} Zeichen (darüber = zu lang)")
    print()
    print("=" * 80)
    
    total_issues = 0
    
    # Fehlende Meta-Descriptions
    print("\n🔴 FEHLENDE META-DESCRIPTIONS")
    print("-" * 80)
    for lang in LANGUAGES:
        missing = results['missing'][lang]
        if missing:
            print(f"\n{lang.upper()} ({len(missing)} fehlend):")
            for page in sorted(missing):
                print(f"  • {page}")
            total_issues += len(missing)
    if total_issues == 0:
        print("✓ Keine fehlenden Meta-Descriptions")
    
    # Leere Meta-Descriptions
    empty_count = sum(len(results['empty'][lang]) for lang in LANGUAGES)
    print("\n🔴 LEERE META-DESCRIPTIONS")
    print("-" * 80)
    for lang in LANGUAGES:
        empty = results['empty'][lang]
        if empty:
            print(f"\n{lang.upper()} ({len(empty)} leer):")
            for page in sorted(empty):
                print(f"  • {page}")
            total_issues += len(empty)
    if empty_count == 0:
        print("✓ Keine leeren Meta-Descriptions")
    
    # Zu kurz
    short_count = sum(len(results['too_short'][lang]) for lang in LANGUAGES)
    print(f"\n🟡 ZU KURZ (< {MIN_LENGTH} Zeichen)")
    print("-" * 80)
    for lang in LANGUAGES:
        too_short = results['too_short'][lang]
        if too_short:
            print(f"\n{lang.upper()} ({len(too_short)} zu kurz):")
            for page in sorted(too_short):
                print(f"  • {page}")
            total_issues += len(too_short)
    if short_count == 0:
        print("✓ Keine zu kurzen Meta-Descriptions")
    
    # Zu lang
    long_count = sum(len(results['too_long'][lang]) for lang in LANGUAGES)
    print(f"\n🟡 ZU LANG (> {MAX_LENGTH} Zeichen)")
    print("-" * 80)
    for lang in LANGUAGES:
        too_long = results['too_long'][lang]
        if too_long:
            print(f"\n{lang.upper()} ({len(too_long)} zu lang):")
            for page in sorted(too_long):
                print(f"  • {page}")
            total_issues += len(too_long)
    if long_count == 0:
        print("✓ Keine zu langen Meta-Descriptions")
    
    # Suboptimal (aber nicht kritisch)
    subopt_count = sum(len(results['suboptimal'][lang]) for lang in LANGUAGES)
    print(f"\n🟢 SUBOPTIMAL (nicht im {OPTIMAL_MIN}-{OPTIMAL_MAX} Bereich)")
    print("-" * 80)
    for lang in LANGUAGES:
        suboptimal = results['suboptimal'][lang]
        if suboptimal:
            print(f"\n{lang.upper()} ({len(suboptimal)} suboptimal):")
            for page in sorted(suboptimal):
                print(f"  • {page}")
    if subopt_count == 0:
        print("✓ Alle Meta-Descriptions im optimalen Bereich oder kritisch")
    
    # Duplikate
    dup_count = sum(len(results['duplicates'][lang]) for lang in LANGUAGES)
    print("\n🔴 DUPLIKATE")
    print("-" * 80)
    for lang in LANGUAGES:
        duplicates = results['duplicates'][lang]
        if duplicates:
            print(f"\n{lang.upper()} ({len(duplicates)} Duplikate):")
            for dup in duplicates:
                print(f"  • {dup}")
            total_issues += len(duplicates)
    if dup_count == 0:
        print("✓ Keine duplizierten Meta-Descriptions")
    
    # Optimal
    optimal_count = sum(len(results['optimal'][lang]) for lang in LANGUAGES)
    print(f"\n✅ OPTIMAL ({OPTIMAL_MIN}-{OPTIMAL_MAX} Zeichen)")
    print("-" * 80)
    for lang in LANGUAGES:
        optimal = results['optimal'][lang]
        if optimal:
            print(f"\n{lang.upper()} ({len(optimal)} optimal):")
            for page in sorted(optimal)[:5]:  # Nur erste 5 anzeigen
                print(f"  • {page}")
            if len(optimal) > 5:
                print(f"  ... und {len(optimal) - 5} weitere")
    
    # Zusammenfassung
    print("\n" + "=" * 80)
    print("ZUSAMMENFASSUNG")
    print("=" * 80)
    print(f"Kritische Issues (fehlend/leer/zu kurz/zu lang/Duplikate): {total_issues}")
    print(f"Suboptimale Descriptions (nicht im idealen Bereich):       {subopt_count}")
    print(f"Optimale Descriptions ({OPTIMAL_MIN}-{OPTIMAL_MAX} Zeichen):                {optimal_count}")
    print("=" * 80)

if __name__ == '__main__':
    results = check_meta_descriptions()
    print_report(results)
