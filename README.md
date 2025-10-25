# Crafted Theme

A custom WordPress theme built from scratch with a modern development workflow. This theme leverages Gulp for automated asset management, Sass for styling, and includes Bootstrap 5.3.7 for a powerful, responsive foundation.

## Features

  * **Custom WordPress Theme:** A clean, starter theme for building bespoke WordPress sites.
  * **Gulp-based Workflow:** Automates tedious development tasks like compiling Sass and minifying assets.
  * **Sass (SCSS) Compilation:** Writes modular, maintainable CSS with Sass.
  * **PostCSS Integration:** Adds browser prefixes automatically with Autoprefixer and minifies CSS with CSSNano.
  * **JavaScript Bundling:** Concatenates and minifies custom JavaScript files along with third-party libraries.
  * **Live Reloading:** Uses BrowserSync to automatically refresh the browser when changes are made to PHP, Sass, or JavaScript files.
  * **Dependencies:** Integrates with **Bootstrap 5.3.7** and **jQuery**.
  * **Composer Integration:** This theme includes a pre-configured `composer.json` file for managing site-wide WordPress plugins and dependencies.
  * **Required Plugin:** This theme requires either the **Secure Custom Fields (SCF)** or **Advanced Custom Fields Pro (ACF Pro)** plugin for managing custom content fields.

## Prerequisites

Before you begin, ensure you have the following installed:

  * **Node.js & npm:** [Download and install from the official site](https://nodejs.org/).
  * **Composer:** [Download and install from the official site](https://getcomposer.org/).
  * **Local WordPress Environment:** A local development server to run WordPress (e.g., Local by Flywheel, XAMPP, MAMP, Lando, DDEV, etc.).

## Installation

Follow these steps to set up the full development environment.

1.  **Clone the repository and set up WordPress:**
    Clone this repository into your WordPress `wp-content/themes` directory.

    ```bash
    cd /path/to/your/wordpress/installation/wp-content/themes/
    git clone https://github.com/gillmourtunhira/crafted-theme.git
    ```

2.  **Move Composer configuration to the WordPress root:**
    To manage plugins and other WordPress dependencies, the `composer.json` file must be in your WordPress site's root directory.

    ```bash
    cd /path/to/your/wordpress/installation/
    mv wp-content/themes/crafted-theme/composer.json .
    ```

3.  **Install WordPress dependencies with Composer:**
    From your WordPress root directory, run the Composer install command.

    ```bash
    composer install
    ```

    This will create the `vendor/` directory, install WordPress core, and any plugins (like Contact Form 7) defined in `composer.json`.

4.  **Configure `wp-config.php`:**
    Open your WordPress site's `wp-config.php` file and add the following lines **above** the `/* That's all, stop editing! Happy publishing. */` line to tell WordPress where to find your new `wp-content` directory.

    ```php
    // Define the wp-content directory outside of the core folder
    define('WP_CONTENT_DIR', dirname(__FILE__) . '/wp-content');
    define('WP_CONTENT_URL', 'http://your-site.test/wp-content'); // Change this to your site URL

    // Include the Composer autoloader
    require_once( __DIR__ . '/vendor/autoload.php' );
    ```

5.  **Install front-end dependencies:**
    Navigate back into your theme directory and install the Node.js packages for Gulp.

    ```bash
    cd wp-content/themes/crafted-theme/
    npm install
    ```

6.  **Configure BrowserSync:**
    Open `gulpfile.js` and update the `proxy` URL in the `browsersyncServe` function to match your local WordPress development site URL.

7.  **Activate the theme:**
    Log in to your WordPress dashboard, navigate to **Appearance \> Themes**, and activate the "Crafted Theme".

## Usage

### Development Mode

To start your Gulp workflow with live reloading, run the following command from the **theme directory**:

```bash
npm run start
```

  * Compiles Sass from `assets/scss` to `dist/css`.
  * Bundles and minifies JavaScript from `assets/js` to `dist/js`.
  * Watches for changes in your Sass, JavaScript, and PHP files.
  * Automatically reloads the browser when files are saved.

### Production Build

To compile all assets for a production environment, run this command from the **theme directory**:

```bash
npm run build
```

## Plugin Management with Composer

Once your site is set up, you can manage all plugins from the **WordPress root directory** using Composer.

  * **To add a new plugin:**
    ```bash
    composer require wpackagist-plugin/<plugin-slug>:<version>
    ```
  * **To update your plugins:**
    ```bash
    composer update
    ```
  * **To remove a plugin:**
    ```bash
    composer remove wpackagist-plugin/<plugin-slug>
    ```

## File Structure

The final file structure after installation will look like this:

```
/wordpress/
├── composer.json            # Composer PHP dependencies
├── composer.lock            # Composer dependency lock file
├── wp-content/
│   ├── plugins/
│   │   └── contact-form-7/  # Plugin installed via Composer
│   ├── themes/
│   │   └── crafted-theme/   # Your theme directory
│   │       ├── assets/
│   │       ├── dist/
│   │       ├── gulpfile.js
│   │       ├── package.json
│   │       └── ... other theme files
│   └── ...
├── vendor/                  # Composer-managed PHP dependencies (ignored by Git)
├── .gitignore               # Site-wide ignored files
└── ... other WP files
```

## Customization

### Sass

All your styling should be written in `assets/scss/main.scss`. This file includes Bootstrap's source code, allowing you to easily override default variables.

To customize Bootstrap:

1.  Open `assets/scss/main.scss`.
2.  Add your variable overrides **before** the main Bootstrap import.
    ```scss
    // assets/scss/main.scss

    // 1. Custom variable overrides
    $primary: #ff5733;
    $font-family-base: "Roboto", sans-serif;

    // 2. Import Bootstrap (Do not edit this line)
    @import "../../node_modules/bootstrap/scss/bootstrap";

    // 3. Your custom styles
    body {
        color: var(--bs-body-color);
    }
    ```

### JavaScript

All custom JavaScript should be written in `assets/js/main.js`. This file is bundled with Bootstrap's JavaScript and minified into `dist/js/all.js`.

Note that WordPress uses jQuery in no-conflict mode. Any custom jQuery code should be wrapped in a closure to use the `$` shorthand:

```javascript
// assets/js/main.js
(function($) {
    // Your jQuery code here
    $('.my-element').on('click', function() {
        console.log('Element clicked!');
    });
})(jQuery);
```

## License

This theme is provided under the [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html) license.
