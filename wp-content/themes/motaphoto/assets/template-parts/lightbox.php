<?php
    //Données pour la Lightbox
    // Utilisation de WP_Query pour récupérer les objets du CPT "photo"
    $args = array(
        'post_type' => 'photo', //CPT Photo
        'posts_per_page' => -1, //-1 pour récupérer toutes les photos
    );
    
    $query = new WP_Query($args); //requette avec les arguments donnés précédemment
    
    // Vérifier si des articles ont été trouvés
    if ($query->have_posts()) {
        // Initialiser un tableau pour stocker les objets
        $photo_objects = array();
    
        while ($query->have_posts()) {//parcours de toutes les photos
            $query->the_post();
            $categories = get_the_terms(get_the_ID(), 'categorie'); //récupération de la catégorie
            
            // Obtenir les données de la photo pour la lightbox
            $photo_data = array( //stockage des données dans un tableau
                'thumbnail' => get_the_post_thumbnail_url(),
                'reference' => get_post_meta(get_the_ID(), 'reference', true),
                'categorie' => $categories[0]->name,
            );
            $photo_objects[] = $photo_data; //stockage des tableaux de données dans le tableau principal
        }
        wp_reset_postdata();
    }
?>

<script>
            //on passe le tableau à javascript
            let dataPhotos = <?php echo json_encode($photo_objects); ?>;
            
</script>

<?php 
    // Récupère les termes de la custom taxonomy Catégorie pour le post en cours
    $categories = get_the_terms(get_the_ID(), 'categorie');
?>
<div class="lightbox-overlay inactive" id="lightbox-overlay"></div>
<div class="lightbox-modale">
    <div id="lightbox" class="inactive">
        
        <div class="lightbox-previous" id="lightbox-previous" onclick="leftLightbox()"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-previous.png"></div>
        <div class="lightbox-image"><img src='<?php echo get_the_post_thumbnail_url(); ?>' alt="image de la lightbox" id="lightbox-info-img"/></div>
        <div class="lightbox-next" id="lightbox-next" onclick="rightLightbox()"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-next.png"></div>
    </div>
    <div class="lightbox-infos inactive" id="lightbox-infos">
        <p id='lightbox-info-ref'><?php echo(get_post_meta(get_the_ID(), 'reference', true)); ?></p>
        <p id='lightbox-info-cat'><?php $categories = get_the_terms(get_the_ID(), 'categorie');
    if ($categories && !is_wp_error($categories)) {
        foreach ($categories as $categorie) { 
            echo $categorie->name;
        }
    } else {
        echo 'Aucune catégorie définie pour cet article.';
    }?></p>
    </div>
    <div class="lightbox-cross inactive" id="lightbox-cross">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/button-cross.png" alt="bouton de fermeture de modale"/>
    </div>
</div>