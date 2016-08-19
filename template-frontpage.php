<?php
/**
 *Template Name: Frontpage
 *
 * @package bender
 */

get_header(); ?>

	<div id="content" class="site-content">
		<main id="main" class="site-main" role="main">
            <?php

            do_action( 'bender_frontpage_before_section_parts' );

			if ( ! has_action( 'bender_frontpage_section_parts' ) ) {

				$sections = apply_filters( 'bender_frontpage_sections_order', array(
                    'hero', 'about', 'services', 'videolightbox', 'counter', 'team', 'news', 'contact'
                ) );

				foreach ( $sections as $section ){
                    /**
                     * Hook before section
                     */
                    do_action('bender_before_section_'.$section );
                    do_action( 'bender_before_section_part', $section );

                    /**
                     * Load section template part
                     */
					get_template_part('section-parts/section', $section );

                    /**
                     * Hook after section
                     */
                    do_action('bender_after_section_part', $section );
                    do_action('bender_after_section_'.$section );
				}

			} else {
				do_action( 'bender_frontpage_section_parts' );
			}

            do_action( 'bender_frontpage_after_section_parts' );

			?>
		</main><!-- #main -->
	</div><!-- #content -->

<?php get_footer(); ?>
