# WordPress Plugin Cookiecutter

Generate a WordPress plugin with Composer, REST API structure, and build tooling.

## Usage

```bash
cookiecutter .
```

## Key variables

| Variable | Description |
|----------|-------------|
| `vendor_slug` | Composer package vendor (e.g. `acme`, `rg-digital`). Use lowercase, hyphens only. |
| `php_namespace` | PHP namespace (e.g. `RgDigital\MyPlugin`). Single backslash. |
| `composer_namespace` | Same as php_namespace but double backslashes for JSON (e.g. `RgDigital\\MyPlugin`). |
| `include_guzzle` | `yes` or `no` — adds Guzzle HTTP client to composer require. |

**Tip:** Keep `php_namespace` and `composer_namespace` in sync: composer needs `\\` where PHP has `\`.
