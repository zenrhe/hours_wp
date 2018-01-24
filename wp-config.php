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
define('AUTH_KEY',         'oHj(dL44S:f@LGO&i<rT?C!v@yW<L%umg>+=ur,1DF>nZH^x!y@$!8EBz2ueT<#I');
define('SECURE_AUTH_KEY',  ';?-&G kPj( Pq%LxNqP23QSeGcYS[ovdNKKf$pue&_fmpPcQQ*0-~gq,|NpD/ZvI');
define('LOGGED_IN_KEY',    'H.cI]X2r`k+=1)A4:7d*H `o%&40uZ7^&J8gXw@x9fnUYD%9[.[uZ2mEru`zYV@D');
define('NONCE_KEY',        '|-><-T<%dR9Lypf,et(-=1wqMJbi;w.0;Fmpm=X89O1C0(*;D-F1FE&<!k:w?OjQ');
define('AUTH_SALT',        '{>(KKm_i<gk:VfY:Auv1*+%&qKm^:Z_QsLGEU|hKEg d@TBwC&_>x@vT3]V/IgVO');
define('SECURE_AUTH_SALT', 'Sh`)vjn1#}w1bMCjO3&G),^Lq`23NBF9fP%WW75sbc9c}Q9` A~I<Sb2|T-FCC#|');
define('LOGGED_IN_SALT',   'ML%SazFF~~jR-pV4iEBE$S4;Ck=AB/p2c 86LDJKU|nB@zjb6N,Fo?_$?dW)?g;h');
define('NONCE_SALT',       'eoU.i%ufF-4L8 h0(m?!p`{[w=)62,yeM}H,~AX8)kG.u-XGRnwH-mB|L.+EdMhr');

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
