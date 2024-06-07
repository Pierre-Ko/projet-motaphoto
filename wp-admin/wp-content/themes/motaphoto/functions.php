<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_scripts() {
    // Ajouter jQuery
    wp_enqueue_script('jquery');
}

function theme_enqueue_styles() {
    // Enfiler les styles CSS
    wp_enqueue_style('monaphoto-style', get_stylesheet_directory_uri() . '/assets/css/style.css');
    
    // Enfiler les scripts JavaScript
    wp_enqueue_script( 'monaphoto-scripts', get_stylesheet_directory_uri() . '/assets/js/app.js', array('jquery'), null, true );
    
    // Localiser les scripts JavaScript pour passer des données PHP à JavaScript
    wp_localize_script('monaphoto-scripts', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('load_more_nonce')
    ));
}
function theme_enqueue_lightbox_script() {
    wp_enqueue_script( 'lightbox-script', get_stylesheet_directory_uri() . '/assets/js/lightbox.js', array('jquery'), null, true );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_lightbox_script' );

function register_my_menu() {
    register_nav_menu( 'main-menu', __( 'Menu principal', 'text-domain' ) );
    register_nav_menu('footer', 'Pied de page');
}
add_action( 'after_setup_theme', 'register_my_menu' );

// Charger plus de photos sur la home avec ajax

function load_more_photos() {
    //superglobale post
    $page = $_POST['page'];

    // On récupère les valeurs des 3 filtres
    $format = isset($_POST['format']) ? $_POST['format'] : '';
    $categorie = isset($_POST['categorie']) ? $_POST['categorie'] : '';
    $order = isset($_POST['order']) ? $_POST['order'] : 'DESC';
    $offset = ($page - 1) * 8; // Calculer l'offset pour récupérer les prochaines 8 photos
    $first_photo_ids = $_POST['first_photo_ids']; // Récupérer les IDs des 8 premières photos
    
    // On définit les arguments de la requête
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'offset' => $offset,
        'post__not_in' => $first_photo_ids, // Exclure les IDs des 8 premières photos
    );

    // Si des filtres sont spécifiés, les ajouter à la requête
    if ($categorie != 'all' || $format != 'all') {
        $args['tax_query'] = array(
            'relation' => 'AND',
        );
    }

    if ($categorie != 'all') {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $categorie,
        );
    }

    if ($format != 'all') {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    $query = new WP_Query($args); //on envoie la requête avec les arguments

    $references = array(); // Initialiser un tableau pour stocker les références des photos chargées

    if ($query->have_posts()) { //si la requête retourne des résultats
        ob_start(); // Commencer la mise en mémoire tampon de la sortie
        while ($query->have_posts()) : $query->the_post();
            $reference = get_post_meta(get_the_ID(), 'reference', true); // Récupérer la référence de la photo
            $urlrelated = get_the_permalink();
            $references[] = $reference; // Ajouter la référence au tableau
            $image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0]; // Récupérer l'URL de l'image associée à la publication
            ?>
            <a href="<?php echo $urlrelated; ?>" class="presentation-images-gauche">
                <div class="image-container photos-container-image presentation-images-gauche" data-photo-reference="<?php echo $reference; ?>">
                    <?php echo get_the_post_thumbnail(); ?>
                </div>
                <div class="overlay">
                    <img class="icon-fullscreen" class="icon-fullscreen custom-fullscreen-icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/icon_fullscreen.png" alt="Icon fullscreen"data-image-url="<?php echo $image_url; ?>">
                    <img class="icon-eye" src="<?php echo get_template_directory_uri(); ?>/assets/images/eye-icon.png" alt="Eye Icon">
                    <div class="info-photo">
                        <p>Référence : <?php echo $reference; ?></p>
                        <p>Catégorie : <?php echo get_the_terms(get_the_ID(), 'categorie') ? get_the_terms(get_the_ID(), 'categorie')[0]->name : 'Aucune catégorie définie pour cet article.'; ?></p>
                    </div>
                </div>
            </a>
            <?php
        endwhile;
        wp_reset_postdata();
        $content = ob_get_clean(); // Récupérer le contenu mis en mémoire tampon
        $response = array(
            'success' => true,
            'data' => array(
                'content' => $content, // Contenu HTML des photos chargées
                'references' => $references // Références des photos chargées
            )
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Pas de photos trouvées'
        );
    }

    // Renvoyer la réponse JSON
    wp_send_json($response);
}
 
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');


// Enqueue le fichier filtre-script.js pour gérer la détection des changements de filtre sur la homepage
function enqueue_filtre_scripts_and_styles() {
    wp_enqueue_script('filtre-script', get_template_directory_uri() . '/assets/js/filtre-script.js', array('jquery'), '', true);
    wp_localize_script('filtre-script', 'ajax_obj', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_filtre_scripts_and_styles');

function filter_photos() {
    // Vérifier la validité du nonce pour des raisons de sécurité
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'load_more_nonce' ) ) {
        wp_send_json_error( 'Nonce non valide' );
    }

    // Récupérer les paramètres de filtre envoyés par la requête AJAX
    $format = isset( $_POST['format'] ) ? sanitize_text_field( $_POST['format'] ) : '';
    $categorie = isset( $_POST['categorie'] ) ? sanitize_text_field( $_POST['categorie'] ) : '';
    $order = isset( $_POST['order'] ) ? sanitize_text_field( $_POST['order'] ) : 'DESC';

    // Construire les arguments de la requête WP_Query pour récupérer les photos filtrées
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => -1, // Récupérer toutes les photos
        'orderby' => 'date',
        'order' => $order,
        'tax_query' => array(
            'relation' => 'AND', // Appliquer les filtres en AND
        ),
    );

    // Ajouter le filtre par catégorie si spécifié
    if ( $categorie != 'all' ) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $categorie,
        );
    }

    // Ajouter le filtre par format si spécifié
    if ( $format != 'all' ) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    // Exécuter la requête WP_Query
    $query = new WP_Query( $args );

    // Vérifier si des photos ont été trouvées
    if ( $query->have_posts() ) {
        // Commencer la mise en mémoire tampon de la sortie
        ob_start();

        // Boucle sur les posts pour afficher les photos
        while ( $query->have_posts() ) {
            $query->the_post();
            // Générer le HTML de chaque photo
            ?>
            <div class="photo">
                <?php the_post_thumbnail(); ?>
                <h2><?php the_title(); ?></h2>
                <!-- Ajouter d'autres informations sur la photo si nécessaire -->
            </div>
            <?php
        }

        // Récupérer le contenu mis en mémoire tampon
        $content = ob_get_clean();

        // Réinitialiser les données de la requête WP_Query
        wp_reset_postdata();

        // Envoyer la réponse JSON avec le contenu des photos filtrées
        wp_send_json_success( $content );
    } else {
        // Envoyer une réponse JSON avec un message d'erreur si aucune photo n'a été trouvée
        wp_send_json_error( 'Aucune photo trouvée avec les filtres sélectionnés.' );
    }
}
// Ajouter l'action pour les utilisateurs connectés et non connectés
add_action('wp_ajax_filter_photos', 'filter_photos'); // Pour les utilisateurs connectés
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos'); // Pour les utilisateurs non connectés

//images bannière
function get_random_portrait_image_url() {
    // Arguments de la requête pour récupérer une image aléatoire de format portrait
    $args = array(
        'post_type' => 'photo', // Remplacez 'photo' par le nom de votre type de publication personnalisé
        'posts_per_page' => 1,
        'orderby' => 'rand',
        'tax_query' => array(
            array(
                'taxonomy' => 'format', // Remplacez 'format' par le nom de votre taxonomie pour les formats
                'field' => 'slug',
                'terms' => 'paysage',
            ),
        ),
    );

    // Exécutez la requête
    $query = new WP_Query($args);

    // Vérifiez si des publications ont été trouvées
    if ($query->have_posts()) {
        // Récupérez l'URL de l'image en vedette de la première publication
        $query->the_post();
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        
        // Réinitialisez la requête pour éviter d'interférer avec d'autres requêtes ultérieures
        wp_reset_postdata();
        
        return $image_url;
    } else {
        return false; // Retourne false si aucune image n'est trouvée
    }
}