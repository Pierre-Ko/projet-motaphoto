<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage motaphoto
 * @since motaphoto 1.0
 */

get_header();

/* Start the Loop */
while (have_posts()) : the_post();

    get_template_part('template-parts/content/content-single');

    if (is_attachment()) {
        // Parent post navigation.
        the_post_navigation(
            array(
                /* translators: %s: Parent post link. */
                'prev_text' => sprintf(__('Published in %s', 'motaphoto'), get_the_title($post->post_parent)),
            )
        );
    }

    // If comments are open or there is at least one comment, load up the comment template.
    if (comments_open() || get_comments_number()) {
        comments_template();
    }

    // Previous/next post navigation.
    $next_label = esc_html__('Next post', 'motaphoto');
    $previous_label = esc_html__('Previous post', 'motaphoto');

    the_post_navigation(
        array(
            'next_text' => '<p class="meta-nav">' . $next_label . '<span class="post-title">%title</span></p>',
            'prev_text' => '<p class="meta-nav">' . $previous_label . '<span class="post-title">%title</span></p>',
        )
    );
endwhile; // End of the loop.

get_footer();
