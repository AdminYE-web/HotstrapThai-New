const fs = require('fs');

const filePath = 'public/js/thai-address.js';
const raw = fs.readFileSync(filePath, 'utf8');

// The file has a structure:
// Lines 1-97: const THAI_ALL_77_PROVINCES = [ ... ]
// Lines 98-286: function initThaiAddressSelector() { ... } and validation stuff
// Lines 287-end: [ { "id": 1, ... } ]

const lines = raw.split('\n');

// Find where the logic starts
const logicStart = lines.findIndex(l => l.includes('function initThaiAddressSelector'));
const logicEnd = lines.findIndex(l => l.trim() === '[' && lines[lines.indexOf(l) + 1].includes('"id"'));

let logic = lines.slice(logicStart, logicEnd).join('\n');

// Update logic to match the new schema
logic = logic.replace(/p\.province/g, 'p.name');
logic = logic.replace(/s\.zip/g, 's.zipcode');

// The full JSON is from logicEnd to the end
const jsonStr = lines.slice(logicEnd).join('\n');

// Build the new file content
const newContent = '/**\n * Thai Address Database & Auto-complete Selector Engine\n * Includes ALL 77 Provinces of Thailand\n */\n\nconst THAI_ALL_77_PROVINCES = ' + jsonStr + '\n\n' + logic;

fs.writeFileSync(filePath, newContent);
console.log('Fixed thai-address.js successfully.');
