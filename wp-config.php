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

//prevent direct access
if(eregi("wp-config.php",$_SERVER["PHP_SELF"])){
header("Location: ./index.php");
exit;
}

define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/masedi/masedi.net/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */

define('DB_NAME', 'masedi_blogdb');

/** MySQL database username */
define('DB_USER', 'masedi_us312DB');

/** MySQL database password */
define('DB_PASSWORD', '!RxzPeRPQZu(');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'EPd&U*$+mz>0e7B[D(:J5/2VTWC3-LeiL1xCD>65&vI:O nf3J[thSj*U`=USq8]');
define('SECURE_AUTH_KEY',  '>!f-|rx|cRn/M-=txe`D-1b}2w$]o/<P~yL>jZQl}l=Xp%c6z,XBa8c_:{vmf!sq');
define('LOGGED_IN_KEY',    '?5J)qb*j-Jd{=]n#9Y4L$Xi5Qc+>l]!a)%8ws#/jOQ;T)cr`d.DH[)*z=5}`(V!{');
define('NONCE_KEY',        'HM65CaL5W,4v)l5RBXi%brQL`/|W<W:uNE.y^9{8^cl~^(`-` Ccsa<fR~r?k4-S');
define('AUTH_SALT',        'oG$!?i+zdF^+T_]}975}qD.xh$]n[QulF%D9a)B0iVmFHKulcB5kX3ZHm8IPcy}s');
define('SECURE_AUTH_SALT', 'K+LkbSK4c>s<9Q5RZH+DBtO4Ua|;GDi|ib54aprEi{*gT&XSl}^j]wyu|0>2{R2o');
define('LOGGED_IN_SALT',   'KJyW*$EY/|b~BY>:q~+%_,yZLvJjNBs!u4;fA@$vE[}@A1!mA%Ul+P9#1K;oHfJG');
define('NONCE_SALT',       'E]SzH-mi,sFd]stYB$DObd;E4<B/,0C07Pe=4#}DB!gb%$YkO!)kn^2Ex4H{wbGk');

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
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', 'id_ID');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* domain mapping */
define( 'SUNRISE', 'on' );

/* multisite */
#define( 'WP_ALLOW_MULTISITE', true );
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', true );
#$base = '/';
define( 'DOMAIN_CURRENT_SITE', 'masedi.net' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
 //Added by WP-Cache Manager
require_once(ABSPATH . 'wp-settings.php');
