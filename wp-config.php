<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

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
define('DB_NAME', 'wpmgg');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'y$Fm<7FrTy&Y.*6j8YBiMZs}M&lQn=yCdtg:z.]T:H%}nX}BuqyDv5<[W&EDN-f*');
define('SECURE_AUTH_KEY',  ')q*W(&louNIg7):hS*o9z#bn&PKGvPF@(kXAH$$K31yQDfKY1GUt3 r+nB,_4L;8');
define('LOGGED_IN_KEY',    'X*O#>1l@NH7jYsm-NKg=0pX#$VRpow/])?mr{)CabA6Z@Sx[%y.96-x0L2Z9F]i7');
define('NONCE_KEY',        'KbQ|_cfX,*e6(*C;iiR>Fwh(DKp4Wo787gxtoo}t7pIqN$iDcsjz|*OUGP? Oy&1');
define('AUTH_SALT',        'i2tsNGH_P1RL)Z$g!9K1)TPy:>I?Q EM:R9^S|+^>|`AI]]rL?pmBTs?cm~GDTX_');
define('SECURE_AUTH_SALT', 'K[PgTgR@6B]:a@}KU&N#n,iieDN!NC?qDqC;Y{>eWfm2#0YpX tVc[8JP:g kyTx');
define('LOGGED_IN_SALT',   'U!~n=5lk~AsHMRxIWH6To9Ox.GsIF8rf9Uu9:E/7@v3u9&M6`p>Grl(iGj6ec,v{');
define('NONCE_SALT',       'yN|F#s}?=>5;X^AY$.$~mGd[pio3CIx$X=%9p>OB#r^IRqEGQG]+Hs{Pz,^TX08l');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpmgg_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
