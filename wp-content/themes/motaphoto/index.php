<?php get_header() ?>
<a href="<?php echo get_template_directory_uri(); ?>/assets/template-parts/modal_contact.php" id="openModalLink">Contact</a>
<img id=imgmodale src="<?php echo get_template_directory_uri(); ?>../assets/images/contact-header.png" alt="Contact Header">
<?php
echo do_shortcode('[contact-form-7 id="0b4f59a" title="Contact form 1"]');
?>
<?php get_footer() ?>