<?php
get_header();

while (have_posts()) : the_post();

    // Récupérer l'ID du custom post type en cours
    $post_id = get_the_ID();

    // Récupérer le thumbnail (image miniature) lié au custom post type
    $thumbnail = get_the_post_thumbnail($post_id, 'large'); // Remplacez 'thumbnail_size' par la taille d'image que vous souhaitez utiliser
?>

    <div class="placement-fiche">
        <div class="fiche-photo">
        <div class="photo_img_mobile inactive active-mobile">
                <?php echo $thumbnail; ?>
            </div>
            <div class="photo-informations">
                <h2><?php echo get_the_title($post_id); ?></h2>
                <p>référence : <?php echo get_post_meta($post_id, 'reference', true) ? get_post_meta($post_id, 'reference', true) : 'Aucune référence définie pour cet article.'; ?></p>
                <p>catégorie : <?php echo get_the_terms($post_id, 'categorie') ? get_the_terms($post_id, 'categorie')[0]->name : 'Aucune catégorie définie pour cet article.'; ?></p>
                <p>format : <?php echo get_the_terms($post_id, 'format') ? get_the_terms($post_id, 'format')[0]->name : 'Aucun format défini pour cet article.'; ?></p>
                <p>type :
                    <?php
                    $type_values = get_post_meta($post_id, 'type', true);

                    if (is_array($type_values) && !empty($type_values)) {
                        echo implode(', ', $type_values);
                    } else {
                        echo 'Aucun type défini pour cet article.';
                    }
                    ?>
                </p>
                <p>date : <?php echo get_the_date('Y', $post_id); ?></p>
            </div>

            <div class="photo_img inactive-mobile" id="photo-lightbox">
                <?php echo $thumbnail; ?>
            </div>
        </div>
    </div>

    <div class="zone-contact-et-miniature">
        <div class="zone-contact">
            <div class="zone-contact-position-texte">
                <p>Cette photo vous intéresse ?</p>
            </div>
            <div class="bouton-contact">
            <button id="openModalBtn">Contact</button>
            </div>
        </div>
        <div class="zone-miniature">
            <div>
                <?php 
                    // Récupérer la miniature du post précédent
                    $prev_custom_post = get_previous_post();
                    $next_custom_post = get_next_post();
                    $next_post_thumbnail = get_the_post_thumbnail($next_custom_post, 'thumbnail');

                    // Afficher la miniature
                    echo $next_post_thumbnail;
                ?>
                <div class="photo-arrows">
                    <?php
                        if ($prev_custom_post) {
                            $prev_custom_post_link = get_permalink($prev_custom_post);
                            echo '<a href="' . esc_url($prev_custom_post_link) . '"><img src="'. get_template_directory_uri() . './assets/images/arrow-left.png" alt="voir la photo précédente" class="arrow-left"/></a>';
                        }

                        if ($next_custom_post) {
                            $next_custom_post_link = get_permalink($next_custom_post);
                            echo '<a href="' . esc_url($next_custom_post_link) . '"><img src="'. get_template_directory_uri() . './assets/images/arrow-right.png" alt="voir la photo suivante" class="arrow-right"/></a>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <h3>VOUS AIMEREZ AUSSI</h3>
    <div class="presentation-images">
       
    <?php 
    $args = array(
        'post_type' => 'photo', // Le type de publication personnalisé
        'posts_per_page' => 2, // Récupère tous les articles de cette taxonomie
        'orderby' => 'rand',
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie', // récupérer les catégories
                'field' => 'slug', 
                'terms' => get_the_terms($post_id, 'categorie') ? get_the_terms($post_id, 'categorie')[0]->slug : '', // on veut des images qui ont la même catégorie que notre image en cours
            ),
        ),
    );

    include(locate_template('assets/template-parts/photo_block.php'));
    ?>
</div>
    </div>

<?php
endwhile;

get_footer();
?>
