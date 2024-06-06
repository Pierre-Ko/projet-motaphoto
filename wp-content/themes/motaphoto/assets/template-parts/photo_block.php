<?php
$first_photo_references = array(); // Initialiser un tableau pour stocker les références des 8 premières photos

$query = new WP_Query($args);

if ($query->have_posts()) {
    $count = 0; // Initialiser un compteur pour suivre le nombre de photos affichées
    while ($query->have_posts()) {
        $query->the_post();
        $reference = get_post_meta(get_the_ID(), 'reference', true); // Récupérer la référence de la photo
        $first_photo_references[] = $reference; // Ajouter la référence au tableau
        $urlrelated = get_the_permalink();
        $image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium')[0]; // Récupérer l'URL de l'image associée à la publication
        ?>
        <a href="<?php echo $urlrelated; ?>" class="presentation-images-gauche">
            <div class="image-container photos-container-image presentation-images-gauche" data-photo-reference="<?php echo $reference; ?>">
                <?php the_post_thumbnail('post-thumbnail', array('class' => 'custom-max-width-image')); ?>
            </div>
            <div class="overlay">
                <img id="fullscreen-icon" class="icon-fullscreen custom-fullscreen-icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/icon_fullscreen.png" alt="Icon fullscreen"data-image-url="<?php echo $image_url; ?>">
                <img class="icon-eye" src="<?php echo get_template_directory_uri(); ?>/assets/images/eye-icon.png" alt="Eye Icon">
                <div class="info-photo">
                    <p>Référence : <?php echo $reference; ?></p>
                    <p>Catégorie : <?php echo get_the_terms(get_the_ID(), 'categorie') ? get_the_terms(get_the_ID(), 'categorie')[0]->name : 'Aucune catégorie définie pour cet article.'; ?></p>
                </div>
            </div>
        </a>
        <?php
        $count++; // Incrémenter le compteur de photos affichées
        if ($count >= 8 && $paged == 1) {
            break; // Si nous sommes sur la première page et que nous avons affiché 8 photos, sortir de la boucle
        }
    }
    wp_reset_postdata(); // Réinitialise la requête WP_Query.
}

?>