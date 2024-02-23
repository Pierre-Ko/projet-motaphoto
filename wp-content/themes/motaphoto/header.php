<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header id="masthead" class="site-header" role="banner">
        <div class="site-branding">
            <?php
            echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home"><img src="' . get_template_directory_uri() . '/assets/images/Logo.png" alt="Logo"></a>';
            ?>
        </div>

        <nav id="site-navigation" class="main-navigation" role="navigation">
            <?php
            // Affiche le menu principal
            wp_nav_menu( array(
                'theme_location' => 'main-menu',
                'menu_id'        => 'header',
            ) );
            ?>
        </nav>
    </header>

    <div id="content" class="site-content">