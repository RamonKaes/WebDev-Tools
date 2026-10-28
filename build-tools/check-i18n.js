#!/usr/bin/env node
/**
 * i18n consistency check
 *
 * Every language file must parse, carry exactly the key paths of en.json and
 * use the same interpolation placeholders ({name} / {{name}}) per string.
 * Arrays (feature lists, how-to steps) are compared as single leaves because
 * their length may legitimately differ between languages.
 *
 * Usage: node build-tools/check-i18n.js
 * Exit code 1 on any difference.
 */
'use strict';

const fs = require('fs');
const path = require('path');

const DIR = path.join(__dirname, '..', 'config', 'i18n');
const LANGS = ['en', 'de', 'es', 'pt', 'fr', 'it'];
const PLACEHOLDER = /\{\{?(\w+)\}?\}/g;

function leaves(value, prefix, out) {
  if (value && typeof value === 'object' && !Array.isArray(value)) {
    for (const [key, child] of Object.entries(value)) {
      leaves(child, prefix ? `${prefix}.${key}` : key, out);
    }
  } else {
    out.set(prefix, value);
  }
  return out;
}

function placeholders(str) {
  const names = new Set();
  for (const m of str.matchAll(PLACEHOLDER)) names.add(m[1]);
  return names;
}

/**
 * A translation may drop a placeholder (French "mois" has no plural "s"),
 * but it must never introduce a name the code does not substitute.
 */
function unknownPlaceholders(reference, translation) {
  const known = placeholders(reference);
  return [...placeholders(translation)].filter(name => !known.has(name));
}

function load(lang) {
  const file = path.join(DIR, `${lang}.json`);
  try {
    return JSON.parse(fs.readFileSync(file, 'utf8'));
  } catch (error) {
    console.error(`✖ ${lang}.json does not parse: ${error.message}`);
    process.exit(1);
  }
}

const reference = leaves(load('en'), '', new Map());
let problems = 0;

for (const lang of LANGS.slice(1)) {
  const current = leaves(load(lang), '', new Map());

  for (const key of reference.keys()) {
    if (!current.has(key)) {
      console.error(`✖ ${lang}: missing key ${key}`);
      problems++;
    }
  }
  for (const key of current.keys()) {
    if (!reference.has(key)) {
      console.error(`✖ ${lang}: extra key ${key}`);
      problems++;
    }
  }
  for (const [key, value] of reference) {
    const other = current.get(key);
    if (typeof value !== 'string' || typeof other !== 'string') continue;
    const unknown = unknownPlaceholders(value, other);
    if (unknown.length) {
      console.error(`✖ ${lang}: ${key} uses placeholder(s) {${unknown.join('}, {')}} that en.json does not define`);
      problems++;
    }
  }
}

if (problems) {
  console.error(`\n${problems} i18n problem(s) found.`);
  process.exit(1);
}

console.log(`✓ i18n: ${LANGS.length} languages, ${reference.size} keys each, placeholders consistent.`);
