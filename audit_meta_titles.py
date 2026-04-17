#!/usr/bin/env python3
"""
Audit script to analyze meta_title entries in i18n JSON files.
Identifies titles with SEO issues (too short/long, word repetitions, single word).
"""

import json
import os
from collections import Counter

# Define thresholds
MIN_LENGTH = 55
MAX_LENGTH = 65

# Languages to check
LANGUAGES = ['en', 'de', 'es', 'fr', 'it', 'pt']

def analyze_title(title):
    """Analyze a single title for SEO issues."""
    issues = []
    length = len(title)
    
    # Check length
    if length < MIN_LENGTH:
        issues.append(f'TOO_SHORT ({length} chars)')
    elif length > MAX_LENGTH:
        issues.append(f'TOO_LONG ({length} chars)')
    
    # Check for single word
    words = title.strip().split()
    if len(words) == 1:
        issues.append('SINGLE_WORD')
    
    # Check for word repetitions (case-insensitive)
    word_counts = Counter(word.lower().strip('–—-,:;.!?') for word in words)
    repetitions = [(word, count) for word, count in word_counts.items() if count > 1]
    if repetitions:
        issues.append(f'REPETITION: {", ".join([f"{w}({c})" for w, c in repetitions])}')
    
    return issues, length

def main():
    base_path = '/var/www/html/WebDev-Tools/config/i18n'
    results = {}
    
    for lang in LANGUAGES:
        file_path = os.path.join(base_path, f'{lang}.json')
        
        try:
            with open(file_path, 'r', encoding='utf-8') as f:
                data = json.load(f)
            
            tools_data = data.get('tools', {})
            lang_results = {}
            
            for tool_id, tool_data in tools_data.items():
                if isinstance(tool_data, dict):
                    meta_title = tool_data.get('meta_title')
                    
                    if meta_title:
                        issues, length = analyze_title(meta_title)
                        if issues:
                            lang_results[tool_id] = {
                                'title': meta_title,
                                'length': length,
                                'issues': issues
                            }
            
            results[lang] = lang_results
        
        except Exception as e:
            print(f'Error reading {lang}.json: {e}')
    
    # Print summary
    print('=' * 80)
    print('META TITLE AUDIT REPORT')
    print('=' * 80)
    print(f'Target length: {MIN_LENGTH}-{MAX_LENGTH} characters\n')
    
    total_issues = 0
    for lang in LANGUAGES:
        lang_issues = results.get(lang, {})
        if lang_issues:
            print(f'\n{lang.upper()} ({len(lang_issues)} tools with issues)')
            print('-' * 80)
            
            for tool_id, data in sorted(lang_issues.items()):
                total_issues += 1
                print(f'\n{tool_id}:')
                print(f'  Title: {data["title"]}')
                print(f'  Length: {data["length"]} chars')
                print(f'  Issues: {", ".join(data["issues"])}')
    
    print('\n' + '=' * 80)
    print(f'TOTAL PROBLEMATIC TITLES: {total_issues}')
    print('=' * 80)

if __name__ == '__main__':
    main()
