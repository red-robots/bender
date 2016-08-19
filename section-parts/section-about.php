<?php
$bender_about_id       = get_theme_mod( 'bender_about_id', esc_html__('about', 'bender') );
$bender_about_disable  = get_theme_mod( 'bender_about_disable' ) == 1 ? true : false;
$bender_about_title    = get_theme_mod( 'bender_about_title', esc_html__('About Us', 'bender' ));
$bender_about_subtitle = get_theme_mod( 'bender_about_subtitle', esc_html__('Section subtitle', 'bender' ));
$bender_about_desc     = get_theme_mod( 'bender_about_desc');
// Get data
$page_ids =  bender_get_section_about_data();
$content_source = get_theme_mod( 'bender_about_content_source' );
if ( ! empty( $page_ids ) ) {
    ?>
    <?php if (!$bender_about_disable) { ?>
        <section id="<?php if ($bender_about_id != '') {
            echo $bender_about_id;
        }; ?>" <?php do_action('bender_section_atts', 'about'); ?> class="<?php echo esc_attr(apply_filters('bender_section_class', 'section-about section-padding onepage-section', 'about')); ?>">
            <?php do_action('bender_section_before_inner', 'about'); ?>
            <div class="container">
                <div class="section-title-area">
                    <?php if ($bender_about_subtitle != '') {
                        echo '<h5 class="section-subtitle">' . esc_html($bender_about_subtitle) . '</h5>';
                    } ?>
                    <?php if ($bender_about_title != '') {
                        echo '<h2 class="section-title">' . esc_html($bender_about_title) . '</h2>';
                    } ?>
                    <?php if ($bender_about_desc != '') {
                        echo '<div class="section-desc">' . wp_kses_post($bender_about_desc) . '</div>';
                    } ?>
                </div>
                <div class="row">
                    <?php
                    if (!empty($page_ids)) {
                        $col = 3;
                        $num_col = 4;
                        $n = count($page_ids);
                        if ($n < 4) {
                            switch ($n) {
                                case 3:
                                    $col = 4;
                                    $num_col = 3;
                                    break;
                                case 2:
                                    $col = 6;
                                    $num_col = 2;
                                    break;
                                default:
                                    $col = 12;
                                    $num_col = 1;
                            }
                        }
                        $j = 0;
                        foreach ($page_ids as $post_id => $settings) {
                            $post_id = $settings['content_page'];
                            $post = get_post($post_id);
                            setup_postdata($post);
                            $class = 'col-lg-' . $col;
                            if ($n == 1) {
                                $class .= ' col-sm-12 ';
                            } else {
                                $class .= ' col-sm-6 ';
                            }
                            if ($j >= $num_col) {
                                $j = 1;
                                $class .= ' clearleft';
                            } else {
                                $j++;
                            }
                            ?>
                            <div class="<?php echo esc_attr($class); ?> wow slideInUp">
                                <?php if (has_post_thumbnail()) { ?>
                                    <div class="about-image"><?php
                                        if ($settings['enable_link']) {
                                            echo '<a href="' . get_permalink($post) . '">';
                                        }
                                        the_post_thumbnail('bender-medium');
                                        if ($settings['enable_link']) {
                                            echo '</a>';
                                        }
                                        ?></div>
                                <?php } ?>
                                <?php if (!$settings['hide_title']) { ?>
                                    <h3><?php

                                        if ($settings['enable_link']) {
                                            echo '<a href="' . get_permalink($post) . '">';
                                        }

                                        the_title();

                                        if ($settings['enable_link']) {
                                            echo '</a>';
                                        }

                                        ?></h3>
                                <?php } ?>
                                <?php
                                if ( $content_source == 'excerpt' ) {
                                    the_excerpt();
                                } else {
                                    the_content();
                                }

                                ?>
                            </div>
                            <?php
                        } // end foreach
                        wp_reset_postdata();
                    }// ! empty pages ids
                    ?>
                </div>
            </div>
            <?php do_action('bender_section_after_inner', 'about'); ?>
        </section>
    <?php }
}
