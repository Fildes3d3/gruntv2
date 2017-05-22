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
define('DB_NAME', 'chasing');

/** MySQL database username */
define('DB_USER', 'chasingp_chasu7e');

/** MySQL database password */
define('DB_PASSWORD', 's?T(-(Dm[E2=');

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
define('AUTH_KEY',         'P9nXI~^6taYPD|&CR(FS#N[^M1 5Rxr9QXUgnB:e2Rc#[K,^`3!bVwmDwi7uU]q1');
define('SECURE_AUTH_KEY',  'umh2BV6D!U;`7Mys&AqJ-]t8=K|l/+Hx(h4<>XYVz1ueM2@2,1pe2%ClJ>!4Y])&');
define('LOGGED_IN_KEY',    '(.(|r[/hIzPw{}SY,]Twl$;c_/3eUa}id+9xx=D[MOK/8i&U;.J2-Z0a[O*t_ejb');
define('NONCE_KEY',        'Y3g@&|ch@IYy.N^@)cuc-!Y`.F[xRdscnY-+5F@%~}q<L]k; o#9_b*;KQ`Z45$(');
define('AUTH_SALT',        'NR /#/9-<%^fq2cq)od~?(U#S9hum6fM93bSL6F+^D+-^t:P9@<~>vv=rA[-*%+9');
define('SECURE_AUTH_SALT', 'Nqr:ey{sB3|JR1423I<{n?@ObX/BjUVRO`U^#AH->aA(h 44p%TW_ZM|r]1~oa ;');
define('LOGGED_IN_SALT',   '2*hKH[D+T`>$JO?Y!q?@:.q?Ai<sIv0Fy_UT+Z%mI%9*ftCD(XoN}(QOGtVv(khX');
define('NONCE_SALT',       '-P^pDgRb_V{|[}kv8W|AB<JN?:eetQ>#r+P%+Ebo_[iaWyav-Bf.c`JW9&R*+~+]');

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
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false );

define('SYMFONY_ENV', 'dev');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
