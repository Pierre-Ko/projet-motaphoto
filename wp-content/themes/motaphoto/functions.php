<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_scripts() {
    // Ajouter jQuery
    wp_enqueue_script('jquery');
}
function theme_enqueue_styles() {
    wp_enqueue_style('monaphoto-style', get_stylesheet_directory_uri() . '/assets/css/style.css');
    wp_enqueue_script( 'monaphoto-scripts', get_stylesheet_directory_uri() . '/assets/js/app.js', array('jquery'), null, true );
    wp_localize_script('monaphoto-scripts', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('load_more_nonce')
    ));
}
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
            ?>
            <a href="<?php echo $urlrelated; ?>" class="presentation-images-gauche">
                <div class="image-container photos-container-image presentation-images-gauche" data-photo-reference="<?php echo $reference; ?>">
                    <?php echo get_the_post_thumbnail(); ?>
                </div>
                <div class="overlay">
                    <img class="icon-fullscreen" class="icon-fullscreen custom-fullscreen-icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/icon_fullscreen.png" alt="Icon fullscreen">
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
