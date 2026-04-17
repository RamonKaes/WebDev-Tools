#!/usr/bin/env python3
"""
Audit script to analyze all page titles (both PHP hardcoded and i18n JSON).
"""

import json
import os
import re
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
    
    # Check for word repetitions (case-insensitive, ignore common separators)
    word_counts = Counter(word.lower().strip('–—-,:;.!?|') for word in words)
    repetitions = [(word, count) for word, count in word_counts.items() if count > 1]
    if repetitions:
        issues.append(f'REPETITION: {", ".join([f"{w}({c})" for w, c in repetitions])}')
    
    return issues, length

def extract_php_titles():
    """Extract all $pageTitle assignments from PHP files."""
    php_titles = {}
    
    # Files to check (relative to base path)
    files_to_check = [
        ('en', 'index.php'),
        ('en', 'about.php'),
        ('en', 'privacy.php'),
        ('en', 'imprint.php'),
        ('de', 'de/index.php'),
        ('de', 'de/about.php'),
        ('de', 'de/privacy.php'),
        ('de', 'de/imprint.php'),
        ('es', 'es/index.php'),
        ('es', 'es/about.php'),
        ('es', 'es/privacy.php'),
        ('es', 'es/imprint.php'),
        ('fr', 'fr/index.php'),
        ('fr', 'fr/about.php'),
        ('fr', 'fr/privacy.php'),
        ('fr', 'fr/imprint.php'),
        ('it', 'it/index.php'),
        ('it', 'it/about.php'),
        ('it', 'it/privacy.php'),
        ('it', 'it/imprint.php'),
        ('pt', 'pt/index.php'),
        ('pt', 'pt/about.php'),
        ('pt', 'pt/privacy.php'),
        ('pt', 'pt/imprint.php'),
    ]
    
    base_path = '/var/www/html/WebDev-Tools'
    
    for lang, file_path in files_to_check:
        full_path = os.path.join(base_path, file_path)
        page_name = os.path.basename(file_path).replace('.php', '')
        
        try:
            with open(full_path, 'r', encoding='utf-8') as f:
                content = f.read()
                # Match $pageTitle = 'text'; or $pageTitle = "text";
                match = re.search(r"\$pageTitle\s*=\s*['\"]([^'\"]+)['\"];", content)
                if match:
                    title = match.group(1)
                    if lang not in php_titles:
                        php_titles[lang] = {}
                    php_titles[lang][page_name] = title
        except Exception as e:
            pass
    
    return php_titles

def main():
    base_path = '/var/www/html/WebDev-Tools/config/i18n'
    
    # Get PHP titles
    php_titles = extract_php_titles()
    
    # Get i18n JSON titles
    json_titles = {}
    for lang in LANGUAGES:
        file_path = os.path.join(base_path, f'{lang}.json')
        
        try:
            with open(file_path, 'r', encoding='utf-8') as f:
                data = json.load(f)
            
            tools_data = data.get('tools', {})
            lang_titles = {}
            
            for tool_id, tool_data in tools_data.items():
                if isinstance(tool_data, dict):
                    meta_title = tool_data.get('meta_title')
                    if meta_title:
                        lang_titles[tool_id] = meta_title
            
            json_titles[lang] = lang_titles
        except Exception as e:
            print(f'Error reading {lang}.json: {e}')
    
    # Analyze all titles
    all_results = {}
    
    print('=' * 80)
    print('COMPLETE PAGE TITLE AUDIT REPORT')
    print('=' * 80)
    print(f'Target length: {MIN_LENGTH}-{MAX_LENGTH} characters\n')
    
    total_issues = 0
    
    for lang in LANGUAGES:
        lang_issues = {}
        
        # Analyze PHP titles
        if lang in php_titles:
            for page_name, title in php_titles[lang].items():
                issues, length = analyze_title(title)
                if issues:
                    lang_issues[f'[PHP] {page_name}'] = {
                        'title': title,
                        'length': length,
                        'issues': issues
                    }
        
        # Analyze JSON titles
        if lang in json_titles:
            for tool_id, title in json_titles[lang].items():
                issues, length = analyze_title(title)
                if issues:
                    lang_issues[f'[Tool] {tool_id}'] = {
                        'title': title,
                        'length': length,
                        'issues': issues
                    }
        
        if lang_issues:
            all_results[lang] = lang_issues
            print(f'\n{lang.upper()} ({len(lang_issues)} pages with issues)')
            print('-' * 80)
            
            for page_id, data in sorted(lang_issues.items()):
                total_issues += 1
                print(f'\n{page_id}:')
                print(f'  Title: {data["title"]}')
                print(f'  Length: {data["length"]} chars')
                print(f'  Issues: {", ".join(data["issues"])}')
    
    print('\n' + '=' * 80)
    print(f'TOTAL PROBLEMATIC TITLES: {total_issues}')
    print('=' * 80)
    
    # Summary by category
    print('\n\nSUMMARY BY ISSUE TYPE:')
    print('-' * 80)
    
    too_short = sum(1 for lang_data in all_results.values() 
                    for page_data in lang_data.values() 
                    if any('TOO_SHORT' in issue for issue in page_data['issues']))
    too_long = sum(1 for lang_data in all_results.values() 
                   for page_data in lang_data.values() 
                   if any('TOO_LONG' in issue for issue in page_data['issues']))
    repetition = sum(1 for lang_data in all_results.values() 
                     for page_data in lang_data.values() 
                     if any('REPETITION' in issue for issue in page_data['issues']))
    single_word = sum(1 for lang_data in all_results.values() 
                      for page_data in lang_data.values() 
                      if any('SINGLE_WORD' in issue for issue in page_data['issues']))
    
    print(f'Too Short (< {MIN_LENGTH} chars): {too_short}')
    print(f'Too Long (> {MAX_LENGTH} chars): {too_long}')
    print(f'Word Repetitions: {repetition}')
    print(f'Single Word: {single_word}')

if __name__ == '__main__':
    main()
