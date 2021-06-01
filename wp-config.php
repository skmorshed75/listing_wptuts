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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'listingwptuts' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'O,91R8gAj/P_7k{6JLWfOSKH/0Oe#J1#`pakcLU/<.W?JfrY8b;vvYP-tK:I]or|' );
define( 'SECURE_AUTH_KEY',  '7CJ$sI=Zk>r` Tv?e vE6}oLFkw?XhC|2OvChMpx.K/JU+yB.^vlS[2/Y)kN+uHX' );
define( 'LOGGED_IN_KEY',    'o#<{^LYB{^K!8^M_L<9.}(1l?Y7qM(Uk[PI%iF2LWwN0C-q,iBI)xn2@($^1rt%U' );
define( 'NONCE_KEY',        '^qqNO#t=c[H>IgJSnNd#! AN+wTr,=DBzHMda:4(]OR&~XP}d>0FR5!56YD8K/El' );
define( 'AUTH_SALT',        'dX`x jc%xg4q/h9e830:b`9#EP!`mq} J7J<_tUto#<U|A]Rz?~x7lvRQuBOx~=G' );
define( 'SECURE_AUTH_SALT', ':Cm%cF?!AY>{g8w0>Q7Jyc@cr!!$^X(OhB $b~Y2Y/:pfd.:|Vss)$YOc+0W_?7;' );
define( 'LOGGED_IN_SALT',   'RBnPX}7sALU;.-gOu/dqg|Y:.nc@Y$Bd!Y.2R{*|Xbgn6m,aoQ6%#A&XDT>JZRw[' );
define( 'NONCE_SALT',       '%%? Fs8!6vluv0nYo/f0N/<k6[lYAU#Z%E~34y|2]OyR+8uzK;.I0@|d .PF]}h7' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
