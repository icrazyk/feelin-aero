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
define('DB_NAME', 'philip9h_aero');

/** MySQL database username */
define('DB_USER', 'philip9h_aero');

/** MySQL database password */
define('DB_PASSWORD', 'BNASiH2WaYTKHexdwor4');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** Config WPCF7 AUTOP **/
define('WPCF7_AUTOP', false);
define('WPCF7_ADMIN_READ_CAPABILITY', 'manage_options');
define('WPCF7_ADMIN_READ_WRITE_CAPABILITY', 'manage_options');

/** Common config **/
define('WP_SITEURL', 'https://feelin-aero.com');
define('WP_HOME', 'https://feelin-aero.com');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ltW-?{G``GeJWb@XEjj!acKA&XvQQPW.VHSm-[lcbyZvuk2pU+]usAz>*pcOu|rD');
define('SECURE_AUTH_KEY',  'sMj3|ADL9uspFD:>_UUAIe27P<D9?RCk<aUCHQ>Iu0.nm2,AOXjj|.1-F#`x-7tL');
define('LOGGED_IN_KEY',    'pL}C;7;B#sjl^n&Izmngtf`$l,-R.H4zxW>Z]5NxKv&bnr(=$v}l3C5S;2|Y,fbX');
define('NONCE_KEY',        'D6 i[6he&ZYVlAI-6-!W%w~7V+0scr$-EwB(}?1;o_)958nVur{@/8DD&PNtrErQ');
define('AUTH_SALT',        'H-d35?3R1),2WqS9;m!O=NZO;ZApthWsLX4PP$B#YXu+woTV A%p+DS:d|H6s1}-');
define('SECURE_AUTH_SALT', 'RpkQ[=Gs`n(T|]d];]W_Ff/DWd(5-N-Huj~dH^p{d{W$-3xg+me_BI`xMGmm0$@<');
define('LOGGED_IN_SALT',   '|gmXE0%Gs|[ Z*Ft>dEs-kzh?XP^`Qh0A68D]}@hRtp|X*; ZzSPZAszw<dKVmQ]');
define('NONCE_SALT',       'hFG,|12sJP)=q[]h<v2ZHU@I])z6njy_!a%[?B4]^_Jp/e~h1|@xxzA*/uN^z+{p');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

$var = 'debug';

if(isset($_GET[$var]))
{
  define('WP_DEBUG', true );
  
  if( $_GET[$var] == 'member1' ) define('WP_DEBUG_DISPLAY', true ); // принудительный показ ошибок
    elseif( $_GET[$var] == 'member2' ) define('WP_DEBUG_LOG', true ); // запись ошибок в файл '/wp-content/debug.log'
    elseif( $_GET[$var] == 'member3' )
    {
      define('SCRIPT_DEBUG', true ); // подключение несжатых скриптов
      define('SAVEQUERIES', true ); // сохраняем все SQL запросы в $wpdb->queries
    }
}

define('WP_DEBUG', true );
define('WP_DEBUG_LOG', true );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
