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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'dom_import_db');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

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
define('AUTH_KEY',         'yNz~-KGwsZ8|_SO~-hG:[ZW40[ZVwsC8|kRN@wsG:skRiPL+xHD]qiP.+xHDtqX6.');
define('SECURE_AUTH_KEY',  'AqmKH:taW1~+LHxta5]aWD_pm3^$MIyB3^fYE,$jIB>nfMA2*fXE.+iEA<ifM<.qM');
define('LOGGED_IN_KEY',    'B7+yfE{<XT.*mME{qXT.^QMEFC>oVR}zvFCsog0:zZGCskgFBrnU4}zYFBrng0}cY');
define('NONCE_KEY',        '40gc:[wVC8-gd:[ZVC0>vUB7nk4}>YUB!okF}>YVwtZ91~dKGxtD91hS]xtD9~-hG');
define('AUTH_SALT',        'R!@kJ0}OK-th1:eaH_~lL1a]#~dVR_-wGC5ldZS_~OGCtlh1[#<*+LEAqifX<.TMI');
define('SECURE_AUTH_SALT', 'a#_pOG:tZW#_SKGxtaqXT.*PIEuqX6$bIEumj3<mi2;+aHA*mi2;ebH<*mL2;QM');
define('LOGGED_IN_SALT',   '~-ZVC!ok4:[ZV|!oN4:sZV|!D9#meL]xtD92ie;]xXDA+ieD9phd:]xWD9+he;]aW');
define('NONCE_SALT',       'mi2;+bHE_~xHDtpW5;~OHDtp95;eaHXEA$jf<,UQ^$jIB>nUQ^$bXE*+mI{mTP*');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);define('FS_METHOD', 'direct');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
