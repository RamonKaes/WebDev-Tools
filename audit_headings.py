#!/usr/bin/env python3
"""
Heading Structure Audit Script
Analyzes heading hierarchy (H1-H6) across all PHP pages
"""

import re
from pathlib import Path
from collections import defaultdict
from typing import List, Dict, Tuple

# Directories to scan
DIRECTORIES = [
    '.',
    'de',
    'es',
    'fr',
    'it',
    'pt'
]

# Tool directories
TOOLS = [
    'base64-encoder-decoder',
    'url-encoder-decoder',
    'json-formatter-validator',
    'px-to-rem-converter',
    'uuid-generator',
    'password-generator',
    'hash-generator',
    'lorem-ipsum',
    'qr-code-generator',
    'string-escaper',
    'code-formatter',
    'data-converter',
    'regex-tester',
    'aspect-ratio-calculator',
    'character-reference',
    'emoji-reference',
    'html-entity-encoder-decoder',
    'jwt-decoder',
    'punycode-converter',
    'sri-generator'
]

# German tool paths
DE_TOOLS = [
    'base64-kodierer-dekodierer',
    'url-kodierer-dekodierer',
    'json-formatierer-validator',
    'px-zu-rem-konverter',
    'uuid-generator',
    'passwort-generator',
    'hash-generator',
    'lorem-ipsum',
    'qr-code-generator',
    'string-maskierer',
    'code-formatierer',
    'daten-konverter',
    'regex-tester',
    'seitenverhaeltnis-rechner',
    'zeichen-referenz',
    'emoji-referenz',
    'html-entity-kodierer-dekodierer',
    'jwt-dekodierer',
    'punycode-konverter',
    'sri-generator'
]

def extract_headings(html: str) -> List[Tuple[int, str]]:
    """Extract all headings (H1-H6) from HTML with their level and content."""
    headings = []
    # Match heading tags with content
    pattern = r'<h([1-6])(?:\s+[^>]*)?>(.+?)</h\1>'
    matches = re.finditer(pattern, html, re.IGNORECASE | re.DOTALL)
    
    for match in matches:
        level = int(match.group(1))
        # Clean content: remove HTML tags, trim whitespace
        content = re.sub(r'<[^>]+>', '', match.group(2))
        content = ' '.join(content.split()).strip()
        headings.append((level, content))
    
    return headings

def check_hierarchy(headings: List[Tuple[int, str]]) -> Dict[str, any]:
    """Check for heading hierarchy issues."""
    issues = {
        'empty': [],
        'gaps': [],
        'wrong_order': [],
        'duplicates': [],
        'multiple_h1': False,
        'no_headings': len(headings) == 0,
        'too_many': len(headings) > 30
    }
    
    # Check for empty headings
    for i, (level, content) in enumerate(headings):
        if not content:
            issues['empty'].append((i+1, level))
    
    # Check for multiple H1s
    h1_count = sum(1 for level, _ in headings if level == 1)
    if h1_count > 1:
        issues['multiple_h1'] = True
    
    # Check for duplicates
    seen = {}
    for i, (level, content) in enumerate(headings):
        if content:
            key = (level, content.lower())
            if key in seen:
                issues['duplicates'].append((i+1, level, content))
            else:
                seen[key] = i+1
    
    # Check for hierarchy gaps and wrong order
    if headings:
        prev_level = 0
        for i, (level, content) in enumerate(headings):
            # First heading should be H1
            if i == 0 and level != 1:
                issues['wrong_order'].append((i+1, f"First heading is H{level}, should be H1"))
            
            # Check for gaps (e.g., H1 → H3, skipping H2)
            if prev_level > 0 and level > prev_level + 1:
                issues['gaps'].append((i+1, f"H{prev_level} → H{level} (skipped H{prev_level+1})"))
            
            prev_level = level
    
    return issues

def get_readable_path(file_path: Path) -> str:
    """Convert file path to readable format."""
    parts = file_path.parts
    if len(parts) > 1:
        return '/'.join(parts[-2:])
    return str(file_path)

def analyze_file(file_path: Path) -> Tuple[List[Tuple[int, str]], Dict]:
    """Analyze a single PHP file for headings."""
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        headings = extract_headings(content)
        issues = check_hierarchy(headings)
        
        return headings, issues
    except Exception as e:
        print(f"Error reading {file_path}: {e}")
        return [], {}

def main():
    print("=" * 80)
    print("HEADING STRUCTURE AUDIT")
    print("=" * 80)
    print()
    
    all_files = []
    
    # Collect root-level pages
    root_pages = ['index.php', 'about.php', 'privacy.php', 'imprint.php']
    for page in root_pages:
        path = Path(page)
        if path.exists():
            all_files.append(path)
    
    # Collect tool pages (English)
    for tool in TOOLS:
        path = Path(tool) / 'index.php'
        if path.exists():
            all_files.append(path)
    
    # Collect localized pages
    for lang_dir in ['de', 'es', 'fr', 'it', 'pt']:
        # Root pages
        for page in root_pages:
            path = Path(lang_dir) / page
            if path.exists():
                all_files.append(path)
        
        # Tool pages - use appropriate tool names
        tool_list = DE_TOOLS if lang_dir == 'de' else TOOLS
        for tool in tool_list:
            path = Path(lang_dir) / tool / 'index.php'
            if path.exists():
                all_files.append(path)
    
    # Statistics
    stats = {
        'total_files': 0,
        'files_with_issues': 0,
        'empty_headings': 0,
        'hierarchy_gaps': 0,
        'wrong_order': 0,
        'duplicates': 0,
        'multiple_h1': 0,
        'no_headings': 0,
        'too_many_headings': 0
    }
    
    files_with_issues = []
    
    print(f"Scanning {len(all_files)} files...\n")
    
    for file_path in sorted(all_files):
        stats['total_files'] += 1
        headings, issues = analyze_file(file_path)
        
        has_issues = False
        issue_types = []
        
        if issues.get('empty'):
            has_issues = True
            stats['empty_headings'] += len(issues['empty'])
            issue_types.append(f"Empty headings: {len(issues['empty'])}")
        
        if issues.get('gaps'):
            has_issues = True
            stats['hierarchy_gaps'] += len(issues['gaps'])
            issue_types.append(f"Hierarchy gaps: {len(issues['gaps'])}")
        
        if issues.get('wrong_order'):
            has_issues = True
            stats['wrong_order'] += len(issues['wrong_order'])
            issue_types.append(f"Wrong order: {len(issues['wrong_order'])}")
        
        if issues.get('duplicates'):
            has_issues = True
            stats['duplicates'] += len(issues['duplicates'])
            issue_types.append(f"Duplicates: {len(issues['duplicates'])}")
        
        if issues.get('multiple_h1'):
            has_issues = True
            stats['multiple_h1'] += 1
            issue_types.append("Multiple H1s")
        
        if issues.get('no_headings'):
            has_issues = True
            stats['no_headings'] += 1
            issue_types.append("No headings")
        
        if issues.get('too_many'):
            has_issues = True
            stats['too_many_headings'] += 1
            issue_types.append(f"Too many: {len(headings)}")
        
        if has_issues:
            stats['files_with_issues'] += 1
            files_with_issues.append({
                'path': file_path,
                'headings': headings,
                'issues': issues,
                'issue_summary': ', '.join(issue_types)
            })
    
    # Print summary
    print("=" * 80)
    print("SUMMARY")
    print("=" * 80)
    print(f"Total files scanned: {stats['total_files']}")
    print(f"Files with issues: {stats['files_with_issues']}")
    print()
    print("Issue breakdown:")
    print(f"  Empty headings: {stats['empty_headings']}")
    print(f"  Hierarchy gaps: {stats['hierarchy_gaps']}")
    print(f"  Wrong order: {stats['wrong_order']}")
    print(f"  Duplicate headings: {stats['duplicates']}")
    print(f"  Multiple H1s: {stats['multiple_h1']}")
    print(f"  No headings: {stats['no_headings']}")
    print(f"  Too many headings: {stats['too_many_headings']}")
    print()
    
    # Print detailed issues
    if files_with_issues:
        print("=" * 80)
        print("DETAILED ISSUES")
        print("=" * 80)
        print()
        
        for item in files_with_issues[:20]:  # Show first 20
            print(f"FILE: {get_readable_path(item['path'])}")
            print(f"Issues: {item['issue_summary']}")
            
            # Show heading structure
            print("Heading structure:")
            for i, (level, content) in enumerate(item['headings'][:10], 1):
                indent = "  " * (level - 1)
                content_display = content[:60] + '...' if len(content) > 60 else content
                print(f"  {i}. {indent}H{level}: {content_display}")
            
            if len(item['headings']) > 10:
                print(f"  ... ({len(item['headings']) - 10} more headings)")
            
            # Show specific issues
            if item['issues']['gaps']:
                print("  Gaps:")
                for pos, gap in item['issues']['gaps'][:3]:
                    print(f"    Position {pos}: {gap}")
            
            if item['issues']['duplicates']:
                print("  Duplicates:")
                for pos, level, content in item['issues']['duplicates'][:3]:
                    print(f"    Position {pos}: H{level} \"{content[:50]}\"")
            
            print()
    
    print("\n" + "=" * 80)
    print(f"Audit complete. {stats['files_with_issues']}/{stats['total_files']} files have issues.")
    print("=" * 80)

if __name__ == '__main__':
    main()
