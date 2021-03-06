<?php
$id       = get_theme_mod( 'bender_videolightbox_id', 'videolightbox' );
$disable  = get_theme_mod( 'bender_videolightbox_disable' ) == 1 ? true : false;
$heading  = get_theme_mod( 'bender_videolightbox_title' );
$video    = get_theme_mod( 'bender_videolightbox_url' );

if ( ! $disable && ( $video || $heading ) ) {
    $image    = get_theme_mod( 'bender_videolightbox_image' );
    ?>
    <?php if ( $image ) { ?>
    <div id="parallax-<?php echo esc_attr( $id ); ?>" class="parallax-<?php echo esc_attr( $id ); ?> parallax-window" data-over-scroll-fix="true" data-z-index="1" data-speed="0.3" data-image-src="<?php echo esc_url( $image ); ?>" data-parallax="scroll" data-position="center" data-bleed="0">
    <?php } ?>
        <section id="<?php if ($id != '') echo esc_attr( $id ); ?>" <?php do_action('bender_section_atts', 'videolightbox'); ?>
             class="<?php echo esc_attr(apply_filters('bender_section_class', 'section-videolightbox section-padding section-padding-larger section-inverse onepage-section', 'videolightbox')); ?>">
            <?php do_action('bender_section_before_inner', 'videolightbox'); ?>
            <div class="container">
                <?php if ( $video ) { ?>
                <div class="videolightbox__icon">
                    <a href="<?php echo esc_url( $video ); ?>" class="popup-video">
                        <span class="video_icon"><i class="fa fa-play"></i></span>
                    </a>
                </div>
                <?php } ?>
                <?php if ( $heading ) { ?>
                <h2 class="videolightbox__heading"><?php echo do_shortcode( wp_kses_post( $heading ) ); ?></h2>
                <?php } ?>
            </div>
            <?php do_action('bender_section_after_inner', 'videolightbox'); ?>
        </section>
    <?php if ( $image ) { ?>
    </div>
    <?php } ?>
<?php  }
