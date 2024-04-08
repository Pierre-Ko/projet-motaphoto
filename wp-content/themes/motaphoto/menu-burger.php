<div id="nav-burger" class="nav_burger">

        <a id="button-close" href="#" class="close">&times;</a>

        <ul class="menu-burger">
            <?php wp_nav_menu( array( 
                'theme_location' => 'main-menu',
                'container' => 'ul', // afin d'éviter d'avoir une div autour 
                'menu_class' => 'navbar', // classe personnalisée
            ) ); ?>
        </ul>
    </div>


    <a href="#" id="button-open">
    <span id="burger-icon">
        <span></span>
        <span></span>
        <span></span>
    </span>
    </a>
    <?php
           