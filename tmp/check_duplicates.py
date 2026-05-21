import json
import os

def find_duplicates(file_path):
    if not os.path.exists(file_path):
        print(f"File not found: {file_path}")
        return
    
    with open(file_path, 'r', encoding='utf-8') as f:
        lines = f.readlines()
        
    keys = {}
    duplicates = []
    
    for i, line in enumerate(lines):
        line = line.strip()
        if not line or line == '{' or line == '}':
            continue
        
        parts = line.split('": "')
        if len(parts) >= 1:
            key = parts[0].strip('"').strip()
            if key in keys:
                duplicates.append((key, keys[key], i + 1))
            keys[key] = i + 1
            
    print(f"\n--- Duplicates in {os.path.basename(file_path)} ---")
    if not duplicates:
        print("No duplicates found.")
    else:
        print(f"Found {len(duplicates)} duplicates.")
        for key, line1, line2 in duplicates[:10]:
            print(f"Key: '{key}' | Lines: {line1} and {line2}")
        if len(duplicates) > 10:
            print("...")

files = [
    'lang/ar.json',
    'lang/en.json',
    'lang/es.json',
    'lang/fr.json'
]

cwd = os.getcwd()
projet_base = r'c:\Users\DELL 7400\Documents\projet\GuideGlutenFree'

for f in files:
    find_duplicates(os.path.join(projet_base, f))
