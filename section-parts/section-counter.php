<?php
$bender_counter_id       = get_theme_mod( 'bender_counter_id', esc_html__('counter', 'bender') );
$bender_counter_disable  = get_theme_mod( 'bender_counter_disable' ) == 1 ? true : false;
$bender_counter_title    = get_theme_mod( 'bender_counter_title', esc_html__('Our Numbers', 'bender' ));
$bender_counter_subtitle = get_theme_mod( 'bender_counter_subtitle', esc_html__('Section subtitle', 'bender' ));

// Get counter data
$boxes = bender_get_section_counter_data();
if ( ! empty ( $boxes ) ) {
    ?>
    <?php if ($bender_counter_disable != '1') : ?>
        <section id="<?php if ($bender_counter_id != '') echo $bender_counter_id; ?>" <?php do_action('bender_section_atts', 'counter'); ?>
                 class="<?php echo esc_attr(apply_filters('bender_section_class', 'section-counter section-padding onepage-section', 'counter')); ?>">
            <?php do_action('bender_section_before_inner', 'counter'); ?>
            <div class="container">

                <div class="section-title-area">
                    <?php if ($bender_counter_subtitle != '') echo '<h5 class="section-subtitle">' . esc_html($bender_counter_subtitle) . '</h5>'; ?>
                    <?php if ($bender_counter_title != '') echo '<h2 class="section-title">' . esc_html($bender_counter_title) . '</h2>'; ?>
                </div>

                <div class="row">
                    <?php
                    $col = 3;
                    $num_col = 4;
                    $n = count( $boxes );
                    if ( $n < 4 ) {
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
                    foreach ($boxes as $i => $box) {
                        $box = wp_parse_args($box,
                            array(
                                'title' => '',
                                'number' => '',
                                'unit_before' => '',
                                'unit_after' => '',
                            )
                        );

                        $class = 'col-sm-6 col-md-' . $col;
                        if ($j >= $num_col) {
                            $j = 1;
                            $class .= ' clearleft';
                        } else {
                            $j++;
                        }
                        ?>

                        <div class="<?php echo esc_attr($class); ?>">
                            <div class="counter_item">
                                <div class="counter__number">
                                    <?php if ($box['unit_before']) { ?>
                                        <span class="n-b"><?php echo esc_html($box['unit_before']); ?></span>
                                    <?php } ?>
                                    <span class="n counter"><?php echo esc_html($box['number']); ?></span>
                                    <?php if ($box['unit_after']) { ?>
                                        <span class="n-a"><?php echo esc_html($box['unit_after']); ?></span>
                                    <?php } ?>
                                </div>
                                <div class="counter_title"><?php echo esc_html($box['title']); ?></div>
                            </div>
                        </div>

                        <?php
                    } // end foreach

                    ?>
                </div>
            </div>
            <?php do_action('bender_section_after_inner', 'counter'); ?>
        </section>
    <?php endif;
}
