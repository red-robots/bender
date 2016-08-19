<?php
$bender_contact_id            = get_theme_mod( 'bender_contact_id', esc_html__('contact', 'bender') );
$bender_contact_disable       = get_theme_mod( 'bender_contact_disable' ) == 1 ?  true : false;
$bender_contact_title         = get_theme_mod( 'bender_contact_title', esc_html__('Get in touch', 'bender' ));
$bender_contact_subtitle      = get_theme_mod( 'bender_contact_subtitle', esc_html__('Section subtitle', 'bender' ));
$bender_contact_cf7           = get_theme_mod( 'bender_contact_cf7' );
$bender_contact_cf7_disable   = get_theme_mod( 'bender_contact_cf7_disable' );
$bender_contact_text          = get_theme_mod( 'bender_contact_text' );
$bender_contact_address_title = get_theme_mod( 'bender_contact_address_title' );
$bender_contact_address       = get_theme_mod( 'bender_contact_address' );
$bender_contact_phone         = get_theme_mod( 'bender_contact_phone' );
$bender_contact_email         = get_theme_mod( 'bender_contact_email' );
$bender_contact_fax           = get_theme_mod( 'bender_contact_fax' );

if ( $bender_contact_cf7 || $bender_contact_text || $bender_contact_address_title || $bender_contact_phone || $bender_contact_email || $bender_contact_fax ) {
    ?>
    <?php if (!$bender_contact_disable) : ?>
        <section id="<?php if ($bender_contact_id != '') echo $bender_contact_id; ?>" <?php do_action('bender_section_atts', 'counter'); ?>
                 class="<?php echo esc_attr(apply_filters('bender_section_class', 'section-contact section-padding  section-meta onepage-section', 'contact')); ?>">
            <?php do_action('bender_section_before_inner', 'contact'); ?>
            <div class="container">
                <div class="section-title-area">
                    <?php if ($bender_contact_subtitle != '') echo '<h5 class="section-subtitle">' . esc_html($bender_contact_subtitle) . '</h5>'; ?>
                    <?php if ($bender_contact_title != '') echo '<h2 class="section-title">' . esc_html($bender_contact_title) . '</h2>'; ?>
                </div>
                <div class="row">

                    <?php if ($bender_contact_cf7_disable != '1') : ?>
                        <?php if (isset($bender_contact_cf7) && $bender_contact_cf7 != '') { ?>
                            <div class="contact-form col-sm-6 wow slideInUp">
                                <?php echo do_shortcode(wp_kses_post($bender_contact_cf7)); ?>
                            </div>
                        <?php } else { ?>
                            <div class="contact-form col-sm-6 wow slideInUp">
                                <br>
                                <small>
                                    <i><?php printf(esc_html__('You can install %1$s plugin and go to Customizer &rarr; Section: Contact &rarr; Section Content to show a working contact form here.', 'bender'), '<a href="' . esc_url('https://wordpress.org/plugins/contact-form-7/', 'bender') . '" target="_blank">Contact Form 7</a>'); ?></i>
                                </small>
                            </div>
                        <?php } ?>
                    <?php endif; ?>

                    <div class="col-sm-6 wow slideInUp">
                        <br>
                        <?php if ($bender_contact_text != '') echo wp_kses_post($bender_contact_text); ?>
                        <br><br>

                        <div class="address-box">

                            <h3><?php if ($bender_contact_address_title != '') echo wp_kses_post($bender_contact_address_title); ?></h3>

                            <?php if ($bender_contact_address != ''): ?>
                                <div class="address-contact">
                                    <span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-map-marker fa-stack-1x fa-inverse"></i></span>

                                    <div class="address-content"><?php echo wp_kses_post($bender_contact_address); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ($bender_contact_phone != ''): ?>
                                <div class="address-contact">
                                    <span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-phone fa-stack-1x fa-inverse"></i></span>

                                    <div class="address-content"><?php echo wp_kses_post($bender_contact_phone); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ($bender_contact_email != ''): ?>
                                <div class="address-contact">
                                    <span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-envelope-o fa-stack-1x fa-inverse"></i></span>

                                    <div class="address-content"><a href="mailto:<?php echo antispambot($bender_contact_email); ?>"><?php echo antispambot($bender_contact_email); ?></a></div>
                                </div>
                            <?php endif; ?>

                            <?php if ($bender_contact_fax != ''): ?>
                                <div class="address-contact">
                                    <span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-fax fa-stack-1x fa-inverse"></i></span>

                                    <div class="address-content"><?php echo wp_kses_post($bender_contact_fax); ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php do_action('bender_section_after_inner', 'contact'); ?>
        </section>
    <?php endif;
}
