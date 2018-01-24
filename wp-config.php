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
	define('DB_PASSWORD', ' ');
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
define('AUTH_KEY',         'x0kOcz-p}`rXd_z-2aRH0i,Cd-]_;uTUv T&o-7F+@ynF5&dDtn#{>qj:a$<BO:3');
define('SECURE_AUTH_KEY',  'e8Z[ZA|pUU@g?apY}@O:d>Z?_/<=/)0}ATn(] __4hzF;EsCVCsE1T%<5Ov[n P|');
define('LOGGED_IN_KEY',    'g|W}N9Fu+;7w!6@-)gd{vQbvyX-wJl-q#eWK~tgVA:6,>!T)ezC-3z@zemuP=ss~');
define('NONCE_KEY',        'h-=hOFT&3w7dKT|3&==v6ise]gz53SL`>N,5RVa;!zOA_Q{n^t+vlWre^(Yv/OVh');
define('AUTH_SALT',        '~-RZ%K^-b/8_DP|7]WDsMe|S+r~Y;x}sa7bT#c7eAt0KNE(KTHM?UQ R)/>9fUvo');
define('SECURE_AUTH_SALT', '$,;Q u{7}|~+E--1&:7nOH2~YhPINdq+1e}/G-;;`Fd-,{e+^vXw,)V$~&@ml}gy');
define('LOGGED_IN_SALT',   '=T#@T ~_gGVJOM2/Wt[Fn_vuQS-.vC /i?Uhokk80Nw+xD$$)F`iN}Zl-v(L-Bb-');
define('NONCE_SALT',       'C+H~Bt7,q4l%e-;O?`kr0qfOQ0T}~DPd/2DaSo#,T.2-<zO#r:Ze*+jm0sY0`t`<');

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
