const fs = require("fs");
const filePath = "public/js/thai-address.js";
const raw = fs.readFileSync(filePath, "utf8");

const parts = raw.split("function initThaiAddressSelector");
let before = parts[0];
let rest = "function initThaiAddressSelector" + parts.slice(1).join("function initThaiAddressSelector");

const arrayStartIndex = rest.indexOf("\n[\n    {\n        \"id\": 1");

if (arrayStartIndex !== -1) {
    const logicStr = rest.substring(0, arrayStartIndex).trim();
    const jsonStr = rest.substring(arrayStartIndex).trim();

    const finalContent = "/**\n * Thai Address Database & Auto-complete Selector Engine\n * Includes ALL 77 Provinces of Thailand\n */\n\nconst THAI_ALL_77_PROVINCES = " + jsonStr + ";\n\n" + logicStr;
    fs.writeFileSync(filePath, finalContent);
    console.log("Fixed syntax error!");
} else {
    console.log("Could not find array start.");
}
