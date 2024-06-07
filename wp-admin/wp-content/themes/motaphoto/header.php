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
            <!-- Bouton ouverture menu burger -->
			<button class="burger">
				<span class="bar"></span>  
			</button> 
            <div id="nav-burger" class="nav_burger">
                <ul class="menu-burger">
                    <?php wp_nav_menu( array( 
                        'theme_location' => 'main-menu',
                        'container' => 'ul', // afin d'éviter d'avoir une div autour 
                        'menu_class' => 'navbar', // classe personnalisée
                    ) ); ?>
                 </ul>
            </div>

        </nav>
    </header>
    

    <div id="content" class="site-content">