---
name: compile-tailwind-styles
description: Use this skill when the user asks to build, compile, or minify the Tailwind CSS styles.
---
# Tailwind CSS Compilation Protocol

The project uses Tailwind CLI configured via `package.json`. Follow these steps to build styles:

1. Do NOT manually edit `assets/css/style.css` (this is a compiled file and will be overwritten).
2. Edit styles inside `input.css` or Tailwind classes inside `.php` files.
3. When the user requests a CSS build, execute the production compile script using the `run_command` tool in the root directory:
   * Command: `npm run build:prod`
4. Wait for the command to execute and inform the user of success.
