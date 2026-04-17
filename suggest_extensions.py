#!/usr/bin/env python3
"""
Auto-extend remaining linkTitle.card entries based on EN templates.
"""

import json
import os

LANGUAGES = ['de', 'es', 'fr', 'it', 'pt']
BASE_PATH = '/var/www/html/WebDev-Tools/config/i18n'

# Extensions to add (keyword additions based on EN improvements)
EXTENSIONS = {
    'passwordGeneratorTool': {
        'keywords': ['customizable strength', 'strong', 'custom'],
        'min_length': 60
    },
    'hashGeneratorTool': {
        'keywords': ['MD5', 'SHA-256', 'SHA-512', 'HMAC'],
        'min_length': 60
    },
    'loremIpsumTool': {
        'keywords': ['customizable', 'paragraphs', 'words'],
        'min_length': 60
    },
    'qrCodeGeneratorTool': {
        'keywords': ['color', 'logo', 'custom', 'options'],
        'min_length': 60
    },
    'stringEscaperTool': {
        'keywords': ['HTML', 'JavaScript', 'JSON', 'SQL', 'CSV'],
        'min_length': 60
    },
    'codeFormatterTool': {
        'keywords': ['HTML', 'CSS', 'JavaScript', 'XML', 'SQL'],
        'min_length': 60
    },
    'dataConverterTool': {
        'keywords': ['JSON', 'XML', 'YAML', 'CSV', 'Unix timestamps'],
        'min_length': 60
    },
    'regexTesterTool': {
        'keywords': ['live', 'match', 'results', 'online'],
        'min_length': 60
    },
    'aspectRatioCalculator': {
        'keywords': ['CSS', 'generator', 'responsive'],
        'min_length': 60
    },
    'characterReferenceTool': {
        'keywords': ['Unicode', 'search', 'symbols'],
        'min_length': 60
    },
    'emojiReferenceTool': {
        'keywords': ['shortcodes', 'reference', 'Unicode'],
        'min_length': 60
    },
    'htmlEntityTool': {
        'keywords': ['special characters', 'encode', 'decode'],
        'min_length': 60
    },
    'jwtDecoderTool': {
        'keywords': ['header', 'payload', 'inspection', 'analyze'],
        'min_length': 60
    },
    'punycodeConverterTool': {
        'keywords': ['ASCII', 'IDN', 'international'],
        'min_length': 60
    },
    'sriGeneratorTool': {
        'keywords': ['integrity', 'secure', 'CDN'],
        'min_length': 60
    }
}

def main():
    print('=' * 80)
    print('RECOMMENDATIONS FOR MANUAL EXTENSION')
    print('=' * 80)
    
    for lang in LANGUAGES:
        file_path = os.path.join(BASE_PATH, f'{lang}.json')
        
        try:
            with open(file_path, 'r', encoding='utf-8') as f:
                data = json.load(f)
            
            tools_data = data.get('tools', {})
            
            print(f'\n{lang.upper()}')
            print('-' * 80)
            
            for tool_id, config in EXTENSIONS.items():
                tool_data = tools_data.get(tool_id, {})
                link_title = tool_data.get('linkTitle', {})
                card_text = link_title.get('card', '')
                
                if card_text and len(card_text) < config['min_length']:
                    print(f'\n{tool_id}:')
                    print(f'  Current ({len(card_text)} chars): {card_text}')
                    print(f'  Suggestion: Add keywords like: {", ".join(config["keywords"][:3])}')
        
        except Exception as e:
            print(f'Error reading {lang}.json: {e}')

if __name__ == '__main__':
    main()
