<?php get_header() ?>
<!-- hero -->
<div class="banniere-img">
    <!--consignes différentes entre le document spécifications fonctionnelles et le doc les Etapes clés p11 qui demande un RANDOM. j'ai fais le choix de prendre la consigne donné par la cliente dans les spécifications fonctionnelles du site-->
    <img id="banniere-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/nathalie-11.jpeg" alt="Photo bannière">
    <img id="banniere-title" src="<?php echo get_template_directory_uri(); ?>/assets/images/titre-hero.png" alt="Titre bannière">
</div>

<!-- Sélecteurs de filtres -->
<div class=filtres>

    <div class="filters-box">
        <div class="filters-left">
        
            <!-- Filtre catégorie -->
            <select id="categorie-select" class="home-filter" onfocus="this.size=10;" onblur="this.size=0;" onchange="this.size=1;this.blur()">
                <option value="all">Catégories</option>
                <?php
                    // Récupérer tous les termes de la taxonomie catégorie
                    $terms = get_terms(array(
                        'taxonomy' => 'categorie',
                        'hide_empty' => false,
                    ));
                    // Vérifier s'il y a des termes
                    if ($terms && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
                        }
                 }
                ?>
            </select>

            <!-- Filtre format -->
            <select id="format-select" class="home-filter">
                <option value="all">Formats</option>
                <?php
                    // Récupérer tous les termes de la taxonomie format
                    $terms = get_terms(array(
                        'taxonomy' => 'format',
                        'hide_empty' => false,
                    ));
                    // Vérifier s'il y a des termes
                    if ($terms && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
                     }
                 }
                ?>
            </select>
        </div>

        <!-- Filtre tri par date -->
        <select id="order-select" class="home-filter">
            <option value="ASC">Trier par</option>
            <option value="ASC">Date - Ordre croissant</option>
            <option value="DESC">Date - Ordre décroissant</option>
        </select>
    </div>
</div>

<!-- Liste des images -->
<div id="photos-container" class="presentation-images">

    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
    $args = new WP_Query(array(
        'post_type' => 'photo', // Le type de publication personnalisé
        'posts_per_page' => 8, // Récupère tous les articles de cette taxonomie
        //'orderby' => 'rand', choix aléatoir
        'order'=> 'DESC',
	    'paged'=> $paged //par défaut on charge les dates croissantes
    ));

    include(locate_template('assets/template-parts/photo_block.php'));
            
    ?>
    
</div>
<!-- Bouton "Charger plus" -->
<div class="load-more-photos-box">
    <button id="load-more-photos">Charger plus</button>
</div>

<?php get_footer() ?>