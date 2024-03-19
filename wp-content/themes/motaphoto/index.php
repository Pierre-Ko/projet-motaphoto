<?php get_header() ?>
<!-- hero -->
<div class="banniere-img">
    <img id="banniere-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/nathalie-11.jpeg" alt="Photo bannière">
    <img id="banniere-title" src="<?php echo get_template_directory_uri(); ?>/assets/images/titre-hero.png" alt="Titre bannière">
</div>

<!-- Sélecteurs de filtres -->
<div class=filtres>

    <div class="filters-box">
        <div class="filters-left">
        
            <!-- Filtre catégorie -->
            <select id="categorie-select" class="home-filter">
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
    $args = array(
        'post_type' => 'photo', // Le type de publication personnalisé
        'posts_per_page' => 8, // Récupère tous les articles de cette taxonomie
        'paged' => 1, //par défaut on charge la page 1
        'order' => 'ASC', //par défaut on charge les dates croissantes
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $urlrelated = get_the_permalink();
            ?>
            <a href="<?php echo $urlrelated; ?>" class="presentation-images-gauche">
                <div class="image-container photos-container-image">
                    <?php the_post_thumbnail('post-thumbnail', array('class' => 'custom-max-width-image')); ?>
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
        }
        wp_reset_postdata(); // Réinitialise la requête WP_Query.
    }
    ?>
    
</div>
<!-- Bouton "Charger plus" -->
<div class="load-more-photos-box">
    <button id="load-more-photos">Charger plus</button>
</div>

<?php get_footer() ?>