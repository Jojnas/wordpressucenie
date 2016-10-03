<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpressucenie');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '<dlj=%#|w7q#=h,o}%680}v;NsZ!G@m%Ok8o.19bPviZ5[eU}tdAf]Lw*aRNnPrE');
define('SECURE_AUTH_KEY',  'vIADlTSD;jfzq|OD9`-F4k}<rP#nuFRdAmi/)vG{Fqf<bQ:-%o06|/{/OPHn~^T#');
define('LOGGED_IN_KEY',    ')y58M=.r% *i(=vR&G)K]Mj`x/uS>kBA]8nV~ch?u`vI)Jt^DC@1?O&&:i,$T.OR');
define('NONCE_KEY',        '>q6VfsT)!.QUxu3X!uciJF#!y$oIUJ5XPGVR:W7`%KQjzL. G?9xzKaE=5A4.<{3');
define('AUTH_SALT',        '7^(6aq&dzK3Y] 6w*HBxTzG0=m>;WT|4DT(0[LK70_k#PnTW9G$8/^Fm8pH} LqB');
define('SECURE_AUTH_SALT', '8.~D~($TkWD5ItC>6)imsj@[<H}@R!ohVfPk6Tn>MyZinPz6=2i]:|R$U:$ ;w]w');
define('LOGGED_IN_SALT',   'f+Y&<xd]9EZ-({_:+ X~UIspH25U>%/reZz@C%moky{xP^hp_b}_2[OrIoMVi1Kr');
define('NONCE_SALT',       '<:]ECi^_EoEf)8NACc`1#Kt7Q5u3%4ndPL9e@d_qdkdc.C,jGW$nh-P3TL$o]O$B');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */

// Enable WP_DEBUG mode
define( 'WP_DEBUG', true );

// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', true );

// Disable display of errors and warnings
define( 'WP_DEBUG_DISPLAY', true );
@ini_set( 'display_errors', 0 );


/* That's all, stop editing! Happy blogging. */

// dont insert break lines in contact form 7
define('WPCF7_AUTOP', false);

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
