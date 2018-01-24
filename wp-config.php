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
 
// Include local configuration
if (file_exists(dirname(__FILE__) . '/local-config.php')) {
	include(dirname(__FILE__) . '/local-config.php');
}

// Global DB config
if (!defined('DB_NAME')) {
	define('DB_NAME', 'hours_wp');
}
if (!defined('DB_USER')) {
	define('DB_USER', 'root');
}
if (!defined('DB_PASSWORD')) {
	define('DB_PASSWORD', 'root');
}
if (!defined('DB_HOST')) {
	define('DB_HOST', 'localhost');
}

/** Database Charset to use in creating database tables. */
if (!defined('DB_CHARSET')) {
	define('DB_CHARSET', 'utf8');
}

/** The Database Collate type. Don't change this if in doubt. */
if (!defined('DB_COLLATE')) {
	define('DB_COLLATE', '');
}

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'B`qpdikM86D_oOPQSu$<VJ<]=]>IQ LDV vxS7|#@3|r&&X8|iQ%#[&6dw<w0wAq');
define('SECURE_AUTH_KEY',  '?#;H5c;Qn(u+(40|&0JhK})nh$lFhzc*}O:uN[%+-~eP0P0~8/$c?=]XZI+(iERj');
define('LOGGED_IN_KEY',    'StCKd(,E)D,|#,1ii?<T0>E^X+lz:@K3l~tGVMX]z}@.kko>|pT4#U,K/`|N^c+M');
define('NONCE_KEY',        '_3`P=EU5|o3:v>0NPv)1P<Y-w-Xqg.PF%j;cuRnIBP,b7YT|-G.g4y{77w,-MXp=');
define('AUTH_SALT',        'G@x})+$c||xt{h #}E6W)Y!)|f:`Oa6,mV*-u BZ z|QWlgmGcn> ^x++e3!}2!I');
define('SECURE_AUTH_SALT', ']Fc;%H[Z5%~ULjwyrAY9jqP6_!-Ow&odV><OfP0o,@RPGsWgp.{V2>p;_`XJ1;p)');
define('LOGGED_IN_SALT',   'nmX;9wj`CXs#K@~3up:=H{QcO?->E^K-;@7OK{BgSJkz;+j>ktjZ g#7^qA1OPOX');
define('NONCE_SALT',       '=rkMF$&L!dC%84rmB=![sHlOY|kwo-d^s^VEPQZ]M69H}U]?_,>OJb&Eg-2(RlNW');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'hrs_';

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
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
if (!defined('WP_DEBUG')) {
	define('WP_DEBUG', true);
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
