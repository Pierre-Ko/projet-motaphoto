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

    //On récupère les valeurs des 3 filtres
    $format = isset($_POST['format']) ? $_POST['format'] : '';
    $categorie = isset($_POST['categorie']) ? $_POST['categorie'] : '';
    $order = isset($_POST['order']) ? $_POST['order'] : 'DESC';

    //On vérifie si le contenu doit être filtré
    if($categorie == 'all' && $format == 'all'){
        //si on veut tout sans filtre
        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => 16,
            'paged' => $page,
            'order' => $order,
        );
    }else if($categorie == 'all'){
        //si on veut seulement toutes les catégories, on filtre uniquement sur le format
        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => 16,
            'paged' => $page,
            'tax_query' => array(
                array(
                    'taxonomy' => 'format',
                    'field' => 'slug',
                    'terms' => $format,
                ),
            ),
            'order' => $order,
        );
    }else if($format== 'all'){
        //si on veut seulement tous les formats, on filtre uniquement sur les catégories
        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => 16,
            'paged' => $page,
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie',
                    'field' => 'slug',
                    'terms' => $categorie,
                ),
            ),
            'order' => $order,
        );
    }else{
        //sinon c'est que l'on filtre à la fois les formats et les catégories
        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => 16,
            'paged' => $page,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'format',
                    'field' => 'slug',
                    'terms' => $format,
                ),
                array(
                    'taxonomy' => 'categorie',
                    'field' => 'slug',
                    'terms' => $categorie,
                ),
            ),
            'order' => $order,
        );
    }

    $query = new WP_Query($args); //on envoie la requette avec les arguments

    if ($query->have_posts()) : //si la requette retourne des résultats
        while ($query->have_posts()) : $query->the_post();
            $urlrelated = get_the_permalink();
            ?>
            <a href="<?php echo $urlrelated; ?>" class="presentation-images-gauche">
                <div class="image-container photos-container-image">
                    <?php echo get_the_post_thumbnail(); ?>
                </div>
                <div class="overlay">
                    <img class="icon-fullscreen" src="<?php echo get_template_directory_uri(); ?>/assets/images/icon_fullscreen.png" alt="Icon fullscreen">
                    <img class="icon-eye" src="<?php echo get_template_directory_uri(); ?>/assets/images/eye-icon.png" alt="Eye Icon">
                    <div class="info-photo">
                        <p>Référence : <?php echo get_post_meta(get_the_ID(), 'reference', true); ?></p>
                        <p>Catégorie : <?php echo get_the_terms(get_the_ID(), 'categorie') ? get_the_terms(get_the_ID(), 'categorie')[0]->name : 'Aucune catégorie définie pour cet article.'; ?></p>
                    </div>
                </div>
            </a>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo 'Pas de photos trouvées<br/>'; //sinon message d'erreur
    endif;

    die();
}


add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');


// Enqueue le fichier filtre-script.js pour gérer la détection des changements de filtre sur la homepage
function enqueue_filtre_scripts_and_styles() {
    wp_enqueue_script('filtre-script', get_template_directory_uri() . '/assets/js/filtre-script.js', array('jquery'), '', true);
    wp_localize_script('filtre-script', 'ajax_obj', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_filtre_scripts_and_styles');