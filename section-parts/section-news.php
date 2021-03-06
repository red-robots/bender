<?php
$bender_news_id        = get_theme_mod( 'bender_news_id', esc_html__('news', 'bender') );
$bender_news_disable   = get_theme_mod( 'bender_news_disable' ) == 1 ? true : false;
$bender_news_title     = get_theme_mod( 'bender_news_title', esc_html__('Latest News', 'bender' ));
$bender_news_subtitle  = get_theme_mod( 'bender_news_subtitle', esc_html__('Section subtitle', 'bender' ));
$bender_news_number    = get_theme_mod( 'bender_news_number', '3' );
$bender_news_more_link = get_theme_mod( 'bender_news_more_link', '#' );
$bender_news_more_text = get_theme_mod( 'bender_news_more_text', esc_html__('Read Our Blog', 'bender' ));
?>
<?php if ( ! $bender_news_disable  ) : ?>
<section id="<?php if ( $bender_news_id != '' ) echo $bender_news_id; ?>" <?php do_action( 'bender_section_atts', 'news' ); ?> class="<?php echo esc_attr( apply_filters( 'bender_section_class', 'section-news section-padding onepage-section', 'news' ) ); ?>">
	<?php do_action( 'bender_section_before_inner', 'news' ); ?>
	<div class="container">
		<div class="section-title-area">
			<?php if ( $bender_news_subtitle != '' ) echo '<h5 class="section-subtitle">' . esc_html( $bender_news_subtitle ) . '</h5>'; ?>
			<?php if ( $bender_news_title != '' ) echo '<h2 class="section-title">' . esc_html( $bender_news_title ) . '</h2>'; ?>
		</div>
		<div class="section-content">
			<div class="row">
				<div class="col-sm-12">
					<div class="blog-entry wow slideInUp">
						<?php query_posts('showposts='.$bender_news_number.'' ); ?>
						<?php if ( have_posts() ) : ?>

							<?php /* Start the Loop */ ?>
							<?php while ( have_posts() ) : the_post(); ?>
								<?php

									/*
									 * Include the Post-Format-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
									 */
									get_template_part( 'template-parts/content', 'list' );
								?>

							<?php endwhile; ?>
						<?php else : ?>
							<?php get_template_part( 'template-parts/content', 'none' ); ?>
						<?php endif; ?>

						<?php if ( $bender_news_more_link != '' ) { ?>
						<div class="all-news">
							<a class="btn btn-theme-primary-outline" href="<?php echo esc_url($bender_news_more_link) ?>"><?php if ( $bender_news_more_text != '' ) echo esc_html( $bender_news_more_text ); ?></a>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>

		</div>
	</div>
	<?php do_action( 'bender_section_after_inner', 'news' ); ?>
</section>
<?php endif;
wp_reset_query();
wp_reset_postdata();

