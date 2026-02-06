# {{ cookiecutter.plugin_name }} — Documentation

Place API documentation, architecture notes, or contribution guidelines here.

## Zip scripts

| Script | Use case |
|--------|----------|
| `pnpm zip` or `npm run zip` | Full build: runs composer, creates distributable zip |
| `pnpm zip:no-composer` | Zip only: uses existing vendor/, skips composer |
| `pnpm zip:ci` | CI: same as zip:no-composer, no terminal pause |
