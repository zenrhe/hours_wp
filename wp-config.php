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
define('AUTH_KEY',         'HXB}+k8_KvBEM3Z=,}7KKs-S_n?kP2YRG|b1(%$80A7L|9w&l:YJ:|NT2[oz5=:r');
define('SECURE_AUTH_KEY',  '/d8DW77ZAx0dwY;-/{P6{6H&=z?{}QR#1s05m:Zozpm}VnWFe|<JNC6+6^/@Z5uf');
define('LOGGED_IN_KEY',    'l[r5_.2:funj$`*O7Ae2PYk %<<x@v0:::Vo*fh V/eU)#,Yev l!lE/UZo7#-2n');
define('NONCE_KEY',        'fUQ+ r59@9vyp^|Z_}+6DBzT-YsaJ~5;a`@n}ZQY<*1qN)ZAs[W-Car7.[8x_5!y');
define('AUTH_SALT',        '{``UF,e!fbW}ct1FhoC[T>!=EZZ+yX;WD9Vj8va`, Pvlgzi|Sc$R|ZPf-zl#$o-');
define('SECURE_AUTH_SALT', '_0R5G7*Ob+xg1DWjK_bS/uGn|9yauFec.3mS)`+#7g.gCrz~9R_SGf3Ke{i2bFE/');
define('LOGGED_IN_SALT',   'tcYu}OXr&*}(Un:}n=^{C8L:+74F=d|_HYw-5)-#MVv#ns5v^tT~iL>p`L%P7+o>');
define('NONCE_SALT',       'x+kJ<6=WYqHEZP0CaJ!x<_+QB+(Cqk+]YzU(L=GaPP|QDnC),W5rR. ;g<j?cnZz');

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
	define('WP_DEBUG', false);
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
