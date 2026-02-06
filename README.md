# WordPress Plugin Cookiecutter

Generate a WordPress plugin with Composer, REST API structure, and build tooling.

## Prerequisites

- [Cookiecutter](https://cookiecutter.readthedocs.io/) (`pip install cookiecutter`)
- PHP 7.4+ with Composer
- Node.js + pnpm or npm (for zip scripts)

## How to use

1. **Generate the plugin**

   ```bash
   cookiecutter .
   ```

   Or from a specific path:

   ```bash
   cookiecutter gh:your-org/cc-wp-plugin
   ```

2. **Enter the prompts** — plugin name, slug, description, author, vendor slug, namespace, license, PHP version, and whether to include Guzzle.

3. **Install dependencies**

   ```bash
   cd my-plugin   # or whatever slug you chose
   composer install
   ```

4. **Activate** the plugin in WordPress (Plugins → Installed Plugins → Activate).

5. **Create a distributable zip** (optional)

   ```bash
   pnpm zip
   # or: npm run zip
   ```

   This runs `composer install --no-dev` and creates `my-plugin.zip` in the project root.

## Key variables

| Variable | Description |
|----------|-------------|
| `vendor_slug` | Composer package vendor (e.g. `acme`, `rg-digital`). Use lowercase, hyphens only. |
| `php_namespace` | PHP namespace (e.g. `RgDigital\MyPlugin`). Single backslash. |
| `composer_namespace` | Same as php_namespace but double backslashes for JSON (e.g. `RgDigital\\MyPlugin`). |
| `include_guzzle` | `yes` or `no` — adds Guzzle HTTP client to composer require. |

**Tip:** Keep `php_namespace` and `composer_namespace` in sync: composer needs `\\` where PHP has `\`.
