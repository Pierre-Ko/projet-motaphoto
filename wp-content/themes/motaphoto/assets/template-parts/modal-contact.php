
<div id="overlay" class="inactive"></div>

<div class="placement-modale inactive" id="placement">
    <div id="modale" class="inactive">
        
    <div class="centrage-contenu-modale">
            
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/Contact-header.png" alt="image de contact" class="image-contact">
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/Contact-header-mobile.png" alt="image de contact sur mobile" class="image-contact-mobile">
            <?php
                // Insérez le shortcode dans le template en utilisant la fonction do_shortcode()
                echo do_shortcode('[contact-form-7 id="0b4f59a" title="Contact form 1"]');
            ?>
        </div>
    </div>
</div>


