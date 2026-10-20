# Tailpine 3.0.x

Tailpine is a Drupal theme built for **Drupal Canvas** and supports
component-based site building.

This guide explains how to create and set up a Tailpine subtheme.

## Requirements

* Drupal 10.2 or later
* Drupal Canvas
* Drush
* Tailpine 3.0.x

## Setup

### 1. Create a Subtheme

Run the following command from your Drupal project root:

```bash
drush --include="web/themes/contrib/tailpine" tailpine:create subtheme
```

Replace `subtheme` with your desired theme machine name.

For example:

```bash
drush --include="web/themes/contrib/tailpine" tailpine:create my_theme
```

### 2. Set Up the Subtheme

Run the setup command using your subtheme's machine name:

```bash
drush --include="web/themes/custom/my_theme" subtheme:setup
```

This command:

* Enables the subtheme.
* Moves the required files and configuration into place.
* Prepares the subtheme for Canvas development.

### 3. Configure the Theme

Go to:

**Administration → Appearance → Settings → Your Theme**

Configure the available Tailpine theme settings, such as:

* Colors
* Typography
* Container settings
* Spacing
* Other theme options

### 4. Build with Canvas

Open **Canvas** from the Drupal administration area.

Create or edit a Canvas page and start building your site using the
available components.

Your customizations should be made in your **subtheme**, not directly in
the Tailpine base theme.

## Tailwind CSS

If you want to use Tailwind CSS in your custom theme, go to your custom
theme directory and run:

```bash
cd web/themes/custom/my_theme
npm install
```

This installs the required frontend dependencies defined by the theme.

## Custom Components

When creating custom components in your subtheme, **try to use Tailpine's
existing CSS variables and design tokens** instead of hardcoding colors,
fonts, spacing, and other design values.

Using Tailpine variables helps keep your custom components consistent with
the theme settings and makes them easier to maintain.

## Development

Make site-specific changes inside your custom subtheme:

```bash
cd web/themes/custom/my_theme
```

Keep the Tailpine base theme unchanged so it can be updated independently.

## Version

This guide applies to **Tailpine 3.0.x**.
