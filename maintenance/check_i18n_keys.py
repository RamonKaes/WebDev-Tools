#!/usr/bin/env python3
import json
from pathlib import Path

BASE = Path(__file__).resolve().parents[1] / 'config' / 'i18n'
langs = [p.name[:-5] for p in BASE.glob('*.json') if p.name.endswith('.json')]

with open(BASE / 'en.json', 'r', encoding='utf-8') as f:
    en = json.load(f)

def flatten(d, prefix=''):
    items = set()
    if isinstance(d, dict):
        for k, v in d.items():
            new_key = f"{prefix}.{k}" if prefix else k
            items |= flatten(v, new_key)
    else:
        items.add(prefix)
    return items

en_keys = flatten(en)

for lang in sorted(langs):
    if lang == 'en':
        continue
    with open(BASE / f'{lang}.json', 'r', encoding='utf-8') as f:
        data = json.load(f)
    keys = flatten(data)
    missing = sorted(list(en_keys - keys))
    extra = sorted(list(keys - en_keys))
    print(f"== {lang} == missing: {len(missing)} extra: {len(extra)}")
    if missing:
        for k in missing[:50]:
            print('  MISSING:', k)
    if extra:
        for k in extra[:50]:
            print('  EXTRA:', k)
    print('')
