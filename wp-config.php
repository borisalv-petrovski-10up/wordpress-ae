<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// $onGae is true on production.
if (isset($_SERVER['GAE_ENV'])) {
    $onGae = true;
} else {
    $onGae = false;
}

// Cache settings
// Disable cache for now, as this does not work on App Engine for PHP 7.2
define('WP_CACHE', false);

// Disable pseudo cron behavior
define('DISABLE_WP_CRON', true);

// Determine HTTP or HTTPS, then set WP_SITEURL and WP_HOME
if ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) {
    $protocol_to_use = 'https://';
} else {
    $protocol_to_use = 'http://';
}
if (isset($_SERVER['HTTP_HOST'])) {
    define('HTTP_HOST', $_SERVER['HTTP_HOST']);
} else {
    define('HTTP_HOST', 'localhost');
}
define('WP_SITEURL', $protocol_to_use . HTTP_HOST);
define('WP_HOME', $protocol_to_use . HTTP_HOST);

// ** MySQL settings - You can get this info from your web host ** //
if ($onGae) {
    /** The name of the Cloud SQL database for WordPress */
    define('DB_NAME', 'wordpress');
    /** Production login info */
    define('DB_HOST', ':/cloudsql/sk-borislav:us-central1:ae-wordpress');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'i53y=3Z2k\'kdh_uB');
} else {
    /** The name of the local database for WordPress */
    define('DB_NAME', 'wordpress');
    /** Local environment MySQL login info */
    define('DB_HOST', '127.0.0.1');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'i53y=3Z2k\'kdh_uB');
}

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'OUP26Fv6hwsATW8qJdBrC4kxFvHl8bgROj+5tLeZKA2Gapw50id/XF8hvyBZ1ziGIvbodpbJLAflLQME');
define('SECURE_AUTH_KEY',  'wXjy9OzpNDrJT9GU8yg0OSaqIn90A1JVIMEpe1scG7aWquMIsZWhj/Sa/9DZlIGFvhveLNFlXvQXYUs3');
define('LOGGED_IN_KEY',    'FrusH8n2vxIkJyC+28qHBGW66/9d3XWjETRYzjLI4wb7kwI7lhpITqappgZbqlOZdEDpAm2TqUpZNW9/');
define('NONCE_KEY',        'WtjosC6deAFIIyzjVaWadYywFR42TWlLQHQzZ7hfM7WtE5ScC6rORH4mNMtxIy7sx91L4hj5UnuQOcwe');
define('AUTH_SALT',        'WfGjNt7eTiVmg2am7L8cjUyFPkps1P8BBHSPBjsiTKbP7BZrn/OCouk81ALMepx3ALnEekXsZQz/68Jh');
define('SECURE_AUTH_SALT', 'bf3OYqt3VYQjtKNXOr+7/Ns2DV/j/RfRbBhBoHqZ3AFbeWyXWbLvA5ICsq3Yk5Nyeb4Gv3LvArDbTnJ/');
define('LOGGED_IN_SALT',   'JZ2qTuI+rhkE8IiAiuj9kGS4+UKMkf7p+8zIXo43eWjVwzWRoAWTjDQJGPEQxdFxuHMw7jhrgipioe/u');
define('NONCE_SALT',       'ewZrWNUIEpEME0w3JGD7KeIgODbtVoup4SeKRuB3jGiUb5bvcsb+0YdbrkHfLF3SfMacf2oltsoQHCjf');

/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change these values to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', !$onGae);

/**
 * This setting logs errors to a file if WP_DEBUG is enabled.
 * These files are NOT supported by App Engine; use WP_DEBUG_DISPLAY instead.
 */
define('WP_DEBUG_LOG', !$onGae);  // Not supported in App Engine

/**
 * This setting displays errors in the application if WP_DEBUG is enabled.
 *
 * WARNING: Enabling WP_DEBUG_DISPLAY in production is not secure.
 * See https://owasp.org/www-project-proactive-controls/v3/en/c10-errors-exceptions
 */
define('WP_DEBUG_DISPLAY', !$onGae);

/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/wordpress/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
