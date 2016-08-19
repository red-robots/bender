<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bender
 */
$bender_btt_disable          = get_theme_mod( 'bender_btt_disable' );
$bender_social_footer_title  = get_theme_mod( 'bender_social_footer_title', esc_html__( 'Keep Updated', 'bender' ) );
$bender_social_twitter       = get_theme_mod( 'bender_social_twitter' );
$bender_social_facebook      = get_theme_mod( 'bender_social_facebook' );
$bender_social_google        = get_theme_mod( 'bender_social_google' );
$bender_social_instagram     = get_theme_mod( 'bender_social_instagram' );
$bender_social_rss           = get_theme_mod( 'bender_social_rss' );
$bender_newsletter_disable   = get_theme_mod( 'bender_newsletter_disable', '1' );
$bender_social_disable 	     = get_theme_mod( 'bender_social_disable', '1' );
$bender_newsletter_title     = get_theme_mod( 'bender_newsletter_title', esc_html__( 'Join our Newsletter', 'bender' ) );
$bender_newsletter_mailchimp = get_theme_mod( 'bender_newsletter_mailchimp' );

?>

	<footer id="colophon" class="site-footer" role="contentinfo">

		<?php if ( $bender_newsletter_disable != '1' || $bender_social_disable != '1' ) : ?>
		<div class="footer-connect">
			<div class="container">
				<div class="row">
					<div class="col-sm-2"></div>

					<?php if ( $bender_newsletter_disable != '1' ) : ?>
					<div class="col-sm-4">
						<div class="footer-subscribe">
							<?php if ( $bender_newsletter_title != '' ) echo '<h5 class="follow-heading">'. $bender_newsletter_title .'</h5>'; ?>
							<form novalidate="" target="_blank" class="" name="mc-embedded-subscribe-form" id="mc-embedded-subscribe-form" method="post" action="<?php if ( $bender_newsletter_mailchimp != '' ) echo $bender_newsletter_mailchimp; ?>">
								<input type="text" placeholder="Enter your e-mail address" id="mce-EMAIL" class="subs_input" name="EMAIL" value="">
								<input type="submit" class="subs-button" value="Subscribe" name="subscribe">
							 </form>
						</div>
					</div>
					<?php endif; ?>

					<div class="<?php if ( $bender_newsletter_disable == '1' ) { echo 'col-sm-8'; } else { echo 'col-sm-4'; } ?>">
						<?php if ( $bender_social_disable != '1' ) : ?>
							<div class="footer-social">
								<?php
								if ( $bender_social_footer_title != '' ) echo '<h5 class="follow-heading">'. $bender_social_footer_title .'</h5>';
								if ( $bender_social_twitter != '' ) echo '<a target="_blank" href="'. $bender_social_twitter .'" title="Twitter"><i class="fa fa-twitter"></i></a>';
								if ( $bender_social_facebook != '' ) echo '<a target="_blank" href="'. $bender_social_facebook .'" title="Facebook"><i class="fa fa-facebook"></i></a>';
								if ( $bender_social_google != '' ) echo '<a target="_blank" href="'. $bender_social_google .'" title="Google Plus"><i class="fa fa-google-plus"></i></a>';
								if ( $bender_social_instagram != '' ) echo '<a target="_blank" href="'. $bender_social_instagram .'" title="Instagram"><i class="fa fa-instagram"></i></a>';
								if ( $bender_social_rss != '' ) echo '<a target="_blank" href="'. $bender_social_rss .'"><i class="fa fa-rss"></i></a>';
								?>
							</div>
						<?php endif; ?>
					</div>
					<div class="col-sm-2"></div>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<div class="site-info">
			<div class="container">
				<?php if ( $bender_btt_disable != '1' ) : ?>
				<div class="btt">
					<a class="back-top-top" href="#page" title="<?php echo esc_html__( 'Back To Top', 'bender' ) ?>"><i class="fa fa-angle-double-up wow flash" data-wow-duration="2s"></i></a>
				</div>
				<?php endif; ?>
                <?php
                /**
                 * hooked bender_footer_site_info
                 * @see bender_footer_site_info
                 */
                //do_action( 'bender_footer_site_info' );

                echo '&copy; '. date('Y') . ' | ' . get_bloginfo('name');
                ?>
            </div>
		</div><!-- .site-info -->

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php 

wp_footer(); 



?>

</body>
</html>
