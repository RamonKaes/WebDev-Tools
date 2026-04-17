#!/usr/bin/env python3
"""
Analyze linkTitle.card lengths in i18n JSON files.
"""

import json
import os

LANGUAGES = ['en', 'de', 'es', 'fr', 'it', 'pt']
BASE_PATH = '/var/www/html/WebDev-Tools/config/i18n'

def main():
    print('=' * 80)
    print('LINKTITLE.CARD LENGTH ANALYSIS')
    print('=' * 80)
    print('Target: 60-80 characters for SEO optimization\n')
    
    for lang in LANGUAGES:
        file_path = os.path.join(BASE_PATH, f'{lang}.json')
        
        try:
            with open(file_path, 'r', encoding='utf-8') as f:
                data = json.load(f)
            
            tools_data = data.get('tools', {})
            
            print(f'\n{lang.upper()}')
            print('-' * 80)
            
            short_count = 0
            optimal_count = 0
            long_count = 0
            
            for tool_id, tool_data in sorted(tools_data.items()):
                if isinstance(tool_data, dict):
                    link_title = tool_data.get('linkTitle', {})
                    if isinstance(link_title, dict):
                        card_text = link_title.get('card', '')
                        if card_text:
                            length = len(card_text)
                            
                            if length < 60:
                                status = 'SHORT'
                                short_count += 1
                            elif length <= 80:
                                status = 'OPTIMAL'
                                optimal_count += 1
                            else:
                                status = 'LONG'
                                long_count += 1
                            
                            print(f'{tool_id:30} | {length:3} chars | {status:7} | {card_text[:70]}')
            
            print(f'\nSummary: Short (<60): {short_count}, Optimal (60-80): {optimal_count}, Long (>80): {long_count}')
        
        except Exception as e:
            print(f'Error reading {lang}.json: {e}')
    
    print('\n' + '=' * 80)

if __name__ == '__main__':
    main()
