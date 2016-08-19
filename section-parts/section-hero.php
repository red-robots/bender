<?php
$bender_hero_id         = get_theme_mod( 'bender_hero_id', esc_html__('hero', 'bender') );
$bender_hero_disable    = get_theme_mod( 'bender_hero_disable' ) == 1 ? true : false ;
$bender_hero_fullscreen = get_theme_mod( 'bender_hero_fullscreen' );
$bender_hero_pdtop      = get_theme_mod( 'bender_hero_pdtop', '10' );
$bender_hero_pdbotom    = get_theme_mod( 'bender_hero_pdbotom', '10' );

$bender_hcl1_enable     = get_theme_mod( 'bender_hcl1_enable', 1 );
$bender_hcl1_largetext  = get_theme_mod( 'bender_hcl1_largetext', wp_kses_post('We are <span class="js-rotating">bender | One Page | Responsive | Perfection</span>', 'bender' ));
$bender_hcl1_smalltext  = get_theme_mod( 'bender_hcl1_smalltext', wp_kses_post('Morbi tempus porta nunc <strong>pharetra quisque</strong> ligula imperdiet posuere<br> vitae felis proin sagittis leo ac tellus blandit sollicitudin quisque vitae placerat.', 'bender') );
$bender_hcl1_btn1_text  = get_theme_mod( 'bender_hcl1_btn1_text', esc_html__('Our Services', 'bender') );
$bender_hcl1_btn1_link  = get_theme_mod( 'bender_hcl1_btn1_link', esc_url( home_url( '/' )).esc_html__('#services', 'bender') );
$bender_hcl1_btn2_text  = get_theme_mod( 'bender_hcl1_btn2_text', esc_html__('Get Started', 'bender') );
$bender_hcl1_btn2_link  = get_theme_mod( 'bender_hcl1_btn2_link', esc_url( home_url( '/' )).esc_html__('#contact', 'bender') );

$hero_content_style = '';
if ( $bender_hero_fullscreen != '1' ) {
	$hero_content_style = ' style="padding-top: '. $bender_hero_pdtop .'%; padding-bottom: '. $bender_hero_pdbotom .'%;"';
}

$_images = get_theme_mod('bender_hero_images');
if (is_string($_images)) {
	$_images = json_decode($_images, true);
}

if (empty($_images) || !is_array($_images)) {
    $_images = array();
}

$images = array();

foreach ( $_images as $m ) {
	$m = wp_parse_args($m, array('image' => ''));
	$_u = bender_get_media_url($m['image']);
	if ( $_u ) {
		$images[] = $_u;
	}
}

$is_parallax =  get_theme_mod( 'bender_hero_parallax' ) == 1 && ! empty( $images ) ;

if ( $is_parallax ) {
    echo '<div id="parallax-hero" class="parallax-hero parallax-window" data-over-scroll-fix="true" data-z-index="1" data-speed="0.3" data-image-src="'.esc_attr( $images[0] ).'" data-parallax="scroll" data-position="center" data-bleed="0">';
}

?>
<?php if ( ! $bender_hero_disable && ! empty ( $_images ) ) : ?>
	<section id="<?php if ($bender_hero_id != '') echo $bender_hero_id; ?>" class="hero-slideshow-wrapper <?php if ($bender_hero_fullscreen == 1) {
		echo 'hero-slideshow-fullscreen';
	} else {
		echo 'hero-slideshow-normal';
	} ?>">
		<?php if ($bender_hcl1_enable == '1') : ?>
			<div class="container"<?php echo $hero_content_style; ?>>
				<div class="hero-content-style1">
					<?php if ($bender_hcl1_largetext != '') echo '<h2 class="hero-large-text">' . wp_kses_post($bender_hcl1_largetext) . '</h2>'; ?>
					<?php if ($bender_hcl1_smalltext != '') echo '<p> ' . wp_kses_post($bender_hcl1_smalltext) . '</p>' ?>
					<?php if ($bender_hcl1_btn1_text != '' && $bender_hcl1_btn1_link != '') echo '<a href="' . esc_url($bender_hcl1_btn1_link) . '" class="btn btn-theme-primary btn-lg">' . wp_kses_post($bender_hcl1_btn1_text) . '</a>'; ?>
					<?php if ($bender_hcl1_btn2_text != '' && $bender_hcl1_btn2_link != '') echo '<a href="' . esc_url($bender_hcl1_btn2_link) . '" class="btn btn-secondary-outline btn-lg">' . wp_kses_post($bender_hcl1_btn2_text) . '</a>'; ?>
				</div>
			</div>
		<?php endif; ?>
		<?php

		if ( ! empty ( $images) && ! $is_parallax ) {
			?>
			<script>
				jQuery(document).ready(function () {
					jQuery('.hero-slideshow-wrapper').backstretch(<?php echo json_encode( $images ) ?>, {
						fade: 750,
						duration: 5000
					});
				});
			</script>
			<?php
		}
	?>
	</section>
<?php endif;

if ( $is_parallax ) {
    echo '</div>'; // end parallax
}

