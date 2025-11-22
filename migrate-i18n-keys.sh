#!/bin/bash
# Migration script to rename i18n keys to more descriptive names

# Backup all i18n files
cp config/i18n/en.json config/i18n/en.json.backup
cp config/i18n/de.json config/i18n/de.json.backup
cp config/i18n/es.json config/i18n/es.json.backup
cp config/i18n/pt.json config/i18n/pt.json.backup
cp config/i18n/fr.json config/i18n/fr.json.backup
cp config/i18n/it.json config/i18n/it.json.backup

echo "Backups created"

# Rename keys in all i18n JSON files
for file in config/i18n/{en,de,es,pt,fr,it}.json; do
  echo "Processing $file..."
  
  # Use jq to rename keys in tools section
  jq 'walk(
    if type == "object" and has("title") and has("page_title") then
      . + {
        toc_title: .title,
        h1_title: .page_title,
        card_description: .description,
        tool_description: .description_long
      } | del(.title, .page_title, .description, .description_long)
    else . end
  )' "$file" > "${file}.tmp"
  
  # Rename keys in seo section
  jq 'if has("seo") then
    .seo |= with_entries(
      .value |= (
        . + {
          meta_title: .pageTitle,
          meta_description: .pageDescription
        } | del(.pageTitle, .pageDescription)
      )
    )
  else . end' "${file}.tmp" > "$file"
  
  rm "${file}.tmp"
done

echo "Key renaming complete"
