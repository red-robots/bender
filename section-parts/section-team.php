<?php
$bender_team_id       = get_theme_mod( 'bender_team_id', esc_html__('team', 'bender') );
$bender_team_disable  = get_theme_mod( 'bender_team_disable' ) ==  1 ? true : false;
$bender_team_title    = get_theme_mod( 'bender_team_title', esc_html__('Our Team', 'bender' ));
$bender_team_subtitle = get_theme_mod( 'bender_team_subtitle', esc_html__('Section subtitle', 'bender' ));
$layout = intval( get_theme_mod( 'bender_team_layout', 3 ) );
$user_ids = bender_get_section_team_data();
if ( ! empty( $user_ids ) ) {
    ?>
    <?php if ( ! $bender_team_disable ) : ?>
        <section id="<?php if ($bender_team_id != '') echo $bender_team_id; ?>" <?php do_action('bender_section_atts', 'team'); ?>
                 class="<?php echo esc_attr(apply_filters('bender_section_class', 'section-team section-padding section-meta onepage-section', 'team')); ?>">
            <?php do_action('bender_section_before_inner', 'team'); ?>
            <div class="container">
                <div class="section-title-area">
                    <?php if ($bender_team_subtitle != '') echo '<h5 class="section-subtitle">' . esc_html($bender_team_subtitle) . '</h5>'; ?>
                    <?php if ($bender_team_title != '') echo '<h2 class="section-title">' . esc_html($bender_team_title) . '</h2>'; ?>
                </div>
                <div class="team-members row">
                    <?php
                    if (!empty($user_ids)) {
                        $n = 0;
                        foreach ($user_ids as $member) {
                            $member = wp_parse_args( $member, array(
                                'user_id'  =>array(),
                            ));
                            $user_id = wp_parse_args( $member['user_id'],array(
                                'id' => '',
                             ) );

                            $image_attributes = wp_get_attachment_image_src( $user_id['id'], 'bender-small' );
                            if ( $image_attributes ) {
                                $image = $image_attributes[0];
                                $data = get_post( $user_id['id'] );
                                $n ++ ;
                                ?>
                                <div class="team-member col-md-<?php echo esc_attr( $layout ); ?> col-sm-6 wow slideInUp">
                                    <div class="member-thumb">
                                        <img src="<?php echo esc_url( $image ); ?>" alt="">
                                        <?php do_action( 'bender_section_team_member_media', $member ); ?>
                                    </div>
                                    <div class="member-info">
                                        <h5 class="member-name"><?php echo esc_html( $data->post_title ); ?></h5>
                                        <span class="member-position"><?php echo esc_html( $data->post_content ); ?></span>
                                    </div>
                                </div>
                                <?php

                            }
                        }
                    }

                    ?>
                </div>
            </div>
            <?php do_action('bender_section_after_inner', 'team'); ?>
        </section>
    <?php endif;
}
