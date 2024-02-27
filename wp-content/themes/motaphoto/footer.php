    <nav id="site-navigation" class="main-navigation" role="navigation">
            <?php
            // Affiche le menu principal
            wp_nav_menu( array(
                'theme_location' => 'monaphoto',
                'menu_id'        => 'footer',
            ) );
            ?>
        </nav>
        
        <?php wp_footer()?>
    
</body>

</html>