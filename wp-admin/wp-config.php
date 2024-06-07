<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link https://fr.wordpress.org/support/article/editing-wp-config-php/ Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'motaphoto' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '|3(vI@eHNr9: c|M+thnpmu|U/^H%2fUN}XCvB:$`2X!ELEp?pnJ[KDw#^Fu2N/^' );
define( 'SECURE_AUTH_KEY',  'wRC??[.0p|Y,qq*GpS%`z#,C,wOJfXowc-BWK$5ES#W!1g58W,g$ilC([NJuI~3}' );
define( 'LOGGED_IN_KEY',    'T]#|}8}O`snnpLP^),lSkP5?_[82@?1,Ydb2DD[)odL!15,KGz_-*E*v9PX]a(kk' );
define( 'NONCE_KEY',        '2R`@_X6Kdmma+Or52<$[$R:n3;cphwh[xqZYrc`C2*-f*<*(ckXpBbsz+%0?k{nF' );
define( 'AUTH_SALT',        '(J>scas`(6C[%qv/)NzA]^1e-`Q~^?<]+lW#SH<lNg-W-l0n2PyrYA<tdi/ofi*$' );
define( 'SECURE_AUTH_SALT', 'En1Oy*q(5%j3vQQD$G&uU<f]*,|}:Exj5%Q;>;+,Aa!K#H#`_9ed$bHhxCY?&m)h' );
define( 'LOGGED_IN_SALT',   '>E1E)?)TwdpFYs+5v.|)Kj4DzWSC}*O7Ti$A!Pw[uSuChxi$P_.s}X8$@%08<58f' );
define( 'NONCE_SALT',       'WoD9U`2z{UsOV$N6`t}o(D%zI DWilDkPY>GcdcI;.wXM%iGr)EUTj<YIb}~Jwd?' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs et développeuses : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs et développeuses d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur la documentation.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
