<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'odata' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'TG%*8,.qo:e]$Q##=nSaM^+:m,XV(6p$ttqnejBS+x3$aUeB`ub# peWSV!5ki6}' );
define( 'SECURE_AUTH_KEY',  'TvkDdJ(KWp[s>T(RAI>m&ka$?f{jSj={V~My,jPFP84QxGkW^+r!?M9?x`|BEMWH' );
define( 'LOGGED_IN_KEY',    ':.PzE)bH5wJ}u$i7x%#:SR!V.<(_COD*@b_]-YCI:.IK&9!acg=_-V^~@v$Or@UM' );
define( 'NONCE_KEY',        'tfwYsZpwwVPdPE~},apM(SrqKw=[3A3Zk*cdk/gF[)Yw$,(~y|}ek13~.Na;$PYo' );
define( 'AUTH_SALT',        'KM/}gLgpM,=M,xiI0fWW^?UT_pYft{%~+3z4brT`Nn0)@w^or^*BY/-}mQ#LqSeo' );
define( 'SECURE_AUTH_SALT', '13%;d[9,LZMai?m)Nj~8oa]lR}}F?DU7Wt>~y&?YIHVih`}E+lB3CW)z!}C]x/M[' );
define( 'LOGGED_IN_SALT',   'N!-R(}RgFok[m&{U; [k2n/D9>,G)TS5nL3JV`5_%DM-^<.7Yx6_3Qj{#+-yFhwd' );
define( 'NONCE_SALT',       '6:>w<I|WrhdZ[PR1];*= ;E|A5%iHLj^4bsd<@!Fm)=v85p>3zQ:0q~a;LfNH@pL' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
