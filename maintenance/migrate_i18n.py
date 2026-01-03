#!/usr/bin/env python3
import json
import sys
from pathlib import Path

def migrate_i18n_file(filepath):
    """Migrate i18n file to new key names"""
    with open(filepath, 'r', encoding='utf-8') as f:
        data = json.load(f)
    
    # Migrate tools section
    if 'tools' in data:
        for tool_id, tool_data in data['tools'].items():
            if 'title' in tool_data:
                tool_data['toc_title'] = tool_data.pop('title')
            if 'page_title' in tool_data:
                tool_data['h1_title'] = tool_data.pop('page_title')
            if 'description' in tool_data:
                tool_data['card_description'] = tool_data.pop('description')
            if 'description_long' in tool_data:
                tool_data['tool_description'] = tool_data.pop('description_long')
    
    # Migrate seo section
    if 'seo' in data:
        for tool_id, seo_data in data['seo'].items():
            if 'pageTitle' in seo_data:
                seo_data['meta_title'] = seo_data.pop('pageTitle')
            if 'pageDescription' in seo_data:
                seo_data['meta_description'] = seo_data.pop('pageDescription')
    
    # Write back with proper formatting
    with open(filepath, 'w', encoding='utf-8') as f:
        json.dump(data, f, ensure_ascii=False, indent=2)
    
    print(f"✓ Migrated {filepath}")

if __name__ == '__main__':
    i18n_dir = Path('config/i18n')
    for lang in ['en', 'de', 'es', 'pt', 'fr', 'it']:
        filepath = i18n_dir / f'{lang}.json'
        migrate_i18n_file(filepath)
    
    print("\n✓ All i18n files migrated successfully!")
