#!/usr/bin/env python3
"""
Audit script to analyze internal link texts across the website.
Identifies generic, empty, or too long link texts, and image links without ALT attributes.
"""

import os
import re
from pathlib import Path
from collections import defaultdict

# Base path
BASE_PATH = '/var/www/html/WebDev-Tools'

# Generic link texts to avoid (case-insensitive)
GENERIC_TEXTS = {
    'en': ['here', 'click here', 'read more', 'more', 'learn more', 'link'],
    'de': ['hier', 'klicken', 'weiterlesen', 'mehr', 'link'],
    'es': ['aquí', 'clic aquí', 'leer más', 'más', 'enlace'],
    'fr': ['ici', 'cliquez ici', 'lire plus', 'plus', 'lien'],
    'it': ['qui', 'clicca qui', 'leggi di più', 'più', 'link'],
    'pt': ['aqui', 'clique aqui', 'leia mais', 'mais', 'link']
}

MAX_LINK_LENGTH = 120

def find_links_in_file(file_path):
    """Extract all links from a file and analyze them."""
    issues = []
    
    try:
        with open(file_path, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()
            lines = content.split('\n')
        
        # Pattern for HTML links: <a href="...">text</a>
        # Also captures image links: <a href="..."><img ... /></a>
        link_pattern = r'<a\s+([^>]*?)>(.*?)</a>'
        
        for match in re.finditer(link_pattern, content, re.DOTALL | re.IGNORECASE):
            attrs = match.group(1)
            link_content = match.group(2).strip()
            
            # Get href attribute
            href_match = re.search(r'href=["\'](.*?)["\']', attrs)
            href = href_match.group(1) if href_match else ''
            
            # Skip external links (http, https, mailto, tel)
            if href.startswith(('http://', 'https://', 'mailto:', 'tel:', '//', '#')):
                continue
            
            # Find line number
            line_num = content[:match.start()].count('\n') + 1
            
            # Check if it's an image link
            if '<img' in link_content.lower():
                # Check for ALT attribute
                alt_match = re.search(r'alt=["\'](.*?)["\']', link_content)
                if not alt_match or not alt_match.group(1).strip():
                    issues.append({
                        'type': 'IMAGE_NO_ALT',
                        'line': line_num,
                        'href': href,
                        'text': '(image link without ALT)',
                        'snippet': link_content[:100]
                    })
                continue
            
            # Remove HTML tags from link text
            link_text = re.sub(r'<[^>]+>', '', link_content).strip()
            
            # Check for empty link text
            if not link_text:
                issues.append({
                    'type': 'EMPTY_TEXT',
                    'line': line_num,
                    'href': href,
                    'text': '',
                    'snippet': match.group(0)[:100]
                })
                continue
            
            # Check for generic link text
            link_text_lower = link_text.lower()
            for lang_texts in GENERIC_TEXTS.values():
                for generic in lang_texts:
                    if link_text_lower == generic.lower():
                        issues.append({
                            'type': 'GENERIC_TEXT',
                            'line': line_num,
                            'href': href,
                            'text': link_text,
                            'snippet': match.group(0)[:150]
                        })
                        break
            
            # Check for too long link text
            if len(link_text) > MAX_LINK_LENGTH:
                issues.append({
                    'type': 'TOO_LONG',
                    'line': line_num,
                    'href': href,
                    'text': link_text[:100] + '...',
                    'length': len(link_text),
                    'snippet': match.group(0)[:150]
                })
    
    except Exception as e:
        pass
    
    return issues

def scan_directory(directory, extensions=['.php', '.html']):
    """Scan directory for files with links."""
    all_issues = defaultdict(list)
    
    for root, dirs, files in os.walk(directory):
        # Skip certain directories
        if any(skip in root for skip in ['node_modules', '.git', 'vendor', 'dist', 'build']):
            continue
        
        for file in files:
            if any(file.endswith(ext) for ext in extensions):
                file_path = os.path.join(root, file)
                rel_path = os.path.relpath(file_path, BASE_PATH)
                
                issues = find_links_in_file(file_path)
                if issues:
                    all_issues[rel_path] = issues
    
    return all_issues

def main():
    print('=' * 80)
    print('INTERNAL LINK TEXT AUDIT REPORT')
    print('=' * 80)
    print(f'Max link text length: {MAX_LINK_LENGTH} characters\n')
    
    # Scan PHP and HTML files
    all_issues = scan_directory(BASE_PATH, ['.php', '.html'])
    
    # Count issues by type
    issue_counts = defaultdict(int)
    total_files = len(all_issues)
    
    for file_path, issues in all_issues.items():
        for issue in issues:
            issue_counts[issue['type']] += 1
    
    # Print summary
    print(f'SUMMARY:')
    print(f'Files with issues: {total_files}')
    print(f'Generic link texts: {issue_counts["GENERIC_TEXT"]}')
    print(f'Empty link texts: {issue_counts["EMPTY_TEXT"]}')
    print(f'Image links without ALT: {issue_counts["IMAGE_NO_ALT"]}')
    print(f'Links too long (>{MAX_LINK_LENGTH} chars): {issue_counts["TOO_LONG"]}')
    print(f'Total issues: {sum(issue_counts.values())}\n')
    
    # Print detailed issues by file
    print('=' * 80)
    print('DETAILED ISSUES BY FILE')
    print('=' * 80)
    
    for file_path in sorted(all_issues.keys()):
        issues = all_issues[file_path]
        print(f'\n{file_path} ({len(issues)} issues)')
        print('-' * 80)
        
        for issue in issues:
            print(f'\nLine {issue["line"]}: {issue["type"]}')
            if issue['type'] == 'GENERIC_TEXT':
                print(f'  Text: "{issue["text"]}"')
                print(f'  Href: {issue["href"]}')
            elif issue['type'] == 'EMPTY_TEXT':
                print(f'  Href: {issue["href"]}')
                print(f'  Snippet: {issue["snippet"]}')
            elif issue['type'] == 'IMAGE_NO_ALT':
                print(f'  Href: {issue["href"]}')
                print(f'  Snippet: {issue["snippet"][:80]}...')
            elif issue['type'] == 'TOO_LONG':
                print(f'  Length: {issue["length"]} chars')
                print(f'  Text: {issue["text"]}')
                print(f'  Href: {issue["href"]}')
    
    print('\n' + '=' * 80)
    print(f'TOTAL ISSUES: {sum(issue_counts.values())} across {total_files} files')
    print('=' * 80)

if __name__ == '__main__':
    main()
