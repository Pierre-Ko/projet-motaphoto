    <nav id="footer-navigation" class="main-navigation" role="navigation">
            <?php
            // Affiche le menu principal
            wp_nav_menu( array(
                'theme_location' => 'footer',
                'menu_id'        => 'footer',
            ) );
            ?>
        </nav>
        <button id="openModalBtn" class="modalnone">Contact</button>
        <?php 
        wp_footer();
        // Inclure la modale de contact
        get_template_part('assets/template-parts/modal-contact');
        ?>
  
</body>

</html>