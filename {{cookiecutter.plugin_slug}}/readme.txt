=== {{ cookiecutter.plugin_name }} ===
Contributors: {{ cookiecutter.author_name }}
Tags: wordpress, plugin
Requires at least: {{ cookiecutter.requires_at_least }}
Tested up to: {{ cookiecutter.tested_up_to }}
Stable tag: {{ cookiecutter.version }}
Requires PHP: {{ cookiecutter.requires_php }}
License: {{ cookiecutter.license }}
License URI: {{ cookiecutter.license_uri }}

{{ cookiecutter.plugin_description }}

== Description ==

{{ cookiecutter.plugin_description }}

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/{{ cookiecutter.plugin_slug }}/` or install via Plugins → Add New
2. Run `composer install` in the plugin directory (or use a pre-built zip with vendor included)
3. Activate the plugin through the Plugins menu in WordPress

== Frequently Asked Questions ==

= Does this plugin require Composer? =

The plugin requires Composer dependencies. Either run `composer install` before activation, or use a pre-built distribution that includes the vendor folder.

== Changelog ==

= {{ cookiecutter.version }} =
* Initial release

== Upgrade Notice ==

= {{ cookiecutter.version }} =
Initial release.
