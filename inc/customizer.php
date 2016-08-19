<?php
/**
 * bender Theme Customizer.
 *
 * @package bender
 */


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function bender_customize_register( $wp_customize ) {


	// Load custom controls
	require get_template_directory() . '/inc/customizer-controls.php';

	// Remove default sections
	$wp_customize->remove_section('colors');
	$wp_customize->remove_section('background_image');

	// Custom WP default control & settings.
	$wp_customize->get_section('title_tagline')->title = esc_html__('Site Title, Tagline & Logo', 'bender');
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/**
	 * Hook to add other customize
	 */
	do_action( 'bender_customize_before_register', $wp_customize );


	$pages  =  get_pages();
	$option_pages = array();
	$option_pages[0] = __( 'Select page', 'bender' );
	foreach( $pages as $p ){
		$option_pages[ $p->ID ] = $p->post_title;
	}

	$users = get_users( array(
		'orderby'      => 'display_name',
		'order'        => 'ASC',
		'number'       => '',
	) );

	$option_users[0] = __( 'Select member', 'bender' );
	foreach( $users as $user ){
		$option_users[ $user->ID ] = $user->display_name;
	}

	/*------------------------------------------------------------------------*/
    /*  Site Identity
    /*------------------------------------------------------------------------*/

    	$wp_customize->add_setting( 'bender_site_image_logo',
			array(
				'sanitize_callback' => 'bender_sanitize_file_url',
				'default'           => ''
			)
		);
    	$wp_customize->add_control( new WP_Customize_Image_Control(
            $wp_customize,
            'bender_site_image_logo',
				array(
					'label' 		=> esc_html__('Site Image Logo', 'bender'),
					'section' 		=> 'title_tagline',
					'description'   => esc_html__('Your site image logo', 'bender'),
				)
			)
		);

	/*------------------------------------------------------------------------*/
    /*  Site Options
    /*------------------------------------------------------------------------*/
		$wp_customize->add_panel( 'bender_options',
			array(
				'priority'       => 22,
			    'capability'     => 'edit_theme_options',
			    'theme_supports' => '',
			    'title'          => esc_html__( 'Theme Options', 'bender' ),
			    'description'    => '',
			)
		);

		/* Global Settings
		----------------------------------------------------------------------*/
		$wp_customize->add_section( 'bender_global_settings' ,
			array(
				'priority'    => 3,
				'title'       => esc_html__( 'Global', 'bender' ),
				'description' => '',
				'panel'       => 'bender_options',
			)
		);


			// Disable Sticky Header
			$wp_customize->add_setting( 'bender_sticky_header_disable',
				array(
					'sanitize_callback' => 'bender_sanitize_checkbox',
					'default'           => '',
				)
			);
			$wp_customize->add_control( 'bender_sticky_header_disable',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Disable Sticky Header?', 'bender'),
					'section'     => 'bender_global_settings',
					'description' => esc_html__('Check this box to disable sticky header when scroll.', 'bender')
				)
			);

			// Disable Animation
			$wp_customize->add_setting( 'bender_animation_disable',
				array(
					'sanitize_callback' => 'bender_sanitize_checkbox',
					'default'           => '',
				)
			);
			$wp_customize->add_control( 'bender_animation_disable',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Disable animation effect?', 'bender'),
					'section'     => 'bender_global_settings',
					'description' => esc_html__('Check this box to disable all element animation when scroll.', 'bender')
				)
			);

			// Disable Animation
			$wp_customize->add_setting( 'bender_btt_disable',
				array(
					'sanitize_callback' => 'bender_sanitize_checkbox',
					'default'           => '',
				)
			);
			$wp_customize->add_control( 'bender_btt_disable',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide footer back to top?', 'bender'),
					'section'     => 'bender_global_settings',
					'description' => esc_html__('Check this box to hide footer back to top button.', 'bender')
				)
			);

		/* Colors
		----------------------------------------------------------------------*/
		$wp_customize->add_section( 'bender_colors_settings' ,
			array(
				'priority'    => 4,
				'title'       => esc_html__( 'Site Colors', 'bender' ),
				'description' => '',
				'panel'       => 'bender_options',
			)
		);
			// Primary Color
			$wp_customize->add_setting( 'bender_primary_color', array('sanitize_callback' => 'sanitize_hex_color_no_hash', 'sanitize_js_callback' => 'maybe_hash_hex_color', 'default' => '#03c4eb' ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bender_primary_color',
				array(
					'label'       => esc_html__( 'Primary Color', 'bender' ),
					'section'     => 'bender_colors_settings',
					'description' => '',
					'priority'    => 1
				)
			));


		/* Header
		----------------------------------------------------------------------*/
		$wp_customize->add_section( 'bender_header_settings' ,
			array(
				'priority'    => 5,
				'title'       => esc_html__( 'Header', 'bender' ),
				'description' => '',
				'panel'       => 'bender_options',
			)
		);

		// Header BG Color
		$wp_customize->add_setting( 'bender_header_bg_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'default' => ''
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bender_header_bg_color',
			array(
				'label'       => esc_html__( 'Background Color', 'bender' ),
				'section'     => 'bender_header_settings',
				'description' => '',
			)
		));


		// Site Title Color
		$wp_customize->add_setting( 'bender_logo_text_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'default' => ''
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bender_logo_text_color',
			array(
				'label'       => esc_html__( 'Site Title Color', 'bender' ),
				'section'     => 'bender_header_settings',
				'description' => esc_html__( 'Only set if you don\'t use an image logo.', 'bender' ),
			)
		));

		// Header Menu Color
		$wp_customize->add_setting( 'bender_menu_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'default' => ''
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bender_menu_color',
			array(
				'label'       => esc_html__( 'Menu Link Color', 'bender' ),
				'section'     => 'bender_header_settings',
				'description' => '',
			)
		));

		// Header Menu Hover Color
		$wp_customize->add_setting( 'bender_menu_hover_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'default' => ''
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bender_menu_hover_color',
			array(
				'label'       => esc_html__( 'Menu Link Hover/Active Color', 'bender' ),
				'section'     => 'bender_header_settings',
				'description' => '',

			)
		));

		// Header Menu Hover BG Color
		$wp_customize->add_setting( 'bender_menu_hover_bg_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'default' => ''
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bender_menu_hover_bg_color',
			array(
				'label'       => esc_html__( 'Menu Link Hover/Active BG Color', 'bender' ),
				'section'     => 'bender_header_settings',
				'description' => '',
			)
		));

		// Reponsive Mobie button color
		$wp_customize->add_setting( 'bender_menu_toggle_button_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'default' => ''
			) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bender_menu_toggle_button_color',
			array(
				'label'       => esc_html__( 'Responsive Menu Button Color', 'bender' ),
				'section'     => 'bender_header_settings',
				'description' => '',
			)
		));

		// Vertical align menu
		$wp_customize->add_setting( 'bender_vertical_align_menu',
			array(
				'sanitize_callback' => 'bender_sanitize_checkbox',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'bender_vertical_align_menu',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Center vertical align for menu', 'bender'),
				'section'     => 'bender_header_settings',
				'description' => esc_html__('If you use logo and your logo is too tall, check this box to auto vertical align menu.', 'bender')
			)
		);


		/* Social Settings
		----------------------------------------------------------------------*/
		$wp_customize->add_section( 'bender_social' ,
			array(
				'priority'    => 6,
				'title'       => esc_html__( 'Social Profiles', 'bender' ),
				'description' => '',
				'panel'       => 'bender_options',
			)
		);

			// Disable Social
			$wp_customize->add_setting( 'bender_social_disable',
				array(
					'sanitize_callback' => 'bender_sanitize_checkbox',
					'default'           => '1',
				)
			);
			$wp_customize->add_control( 'bender_social_disable',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide Footer Social?', 'bender'),
					'section'     => 'bender_social',
					'description' => esc_html__('Check this box to hide footer social section.', 'bender')
				)
			);

			$wp_customize->add_setting( 'bender_social_footer_guide',
				array(
					'sanitize_callback' => 'bender_sanitize_text'
				)
			);
			$wp_customize->add_control( new bender_Misc_Control( $wp_customize, 'bender_social_footer_guide',
				array(
					'section'     => 'bender_social',
					'type'        => 'custom_message',
					'description' => esc_html__( 'These social profiles setting below will display at the footer of your site.', 'bender' )
				)
			));

			// Footer Social Title
			$wp_customize->add_setting( 'bender_social_footer_title',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => esc_html__( 'Keep Updated', 'bender' ),
				)
			);
			$wp_customize->add_control( 'bender_social_footer_title',
				array(
					'label'       => esc_html__('Social Footer Title', 'bender'),
					'section'     => 'bender_social',
					'description' => ''
				)
			);

			// Twitter
			$wp_customize->add_setting( 'bender_social_twitter',
				array(
					'sanitize_callback' => 'esc_url',
					'default'           => '',
				)
			);
			$wp_customize->add_control( 'bender_social_twitter',
				array(
					'label'       => esc_html__('Twitter URL', 'bender'),
					'section'     => 'bender_social',
					'description' => ''
				)
			);
			// Facebook
			$wp_customize->add_setting( 'bender_social_facebook',
				array(
					'sanitize_callback' => 'esc_url',
					'default'           => '',
				)
			);
			$wp_customize->add_control( 'bender_social_facebook',
				array(
					'label'       => esc_html__('Faecbook URL', 'bender'),
					'section'     => 'bender_social',
					'description' => ''
				)
			);
			// Facebook
			$wp_customize->add_setting( 'bender_social_google',
				array(
					'sanitize_callback' => 'esc_url',
					'default'           => '',
				)
			);
			$wp_customize->add_control( 'bender_social_google',
				array(
					'label'       => esc_html__('Google Plus URL', 'bender'),
					'section'     => 'bender_social',
					'description' => ''
				)
			);
			// Instagram
			$wp_customize->add_setting( 'bender_social_instagram',
				array(
					'sanitize_callback' => 'esc_url',
					'default'           => '',
				)
			);
			$wp_customize->add_control( 'bender_social_instagram',
				array(
					'label'       => esc_html__('Instagram URL', 'bender'),
					'section'     => 'bender_social',
					'description' => ''
				)
			);
			// RSS
			$wp_customize->add_setting( 'bender_social_rss',
				array(
					'sanitize_callback' => 'esc_url',
					'default'           => get_bloginfo('rss2_url'),
				)
			);
			$wp_customize->add_control( 'bender_social_rss',
				array(
					'label'       => esc_html__('RSS URL', 'bender'),
					'section'     => 'bender_social',
					'description' => ''
				)
			);

		/* Analytics
		----------------------------------------------------------------------*/
		// Should add as plugin
		// $wp_customize->add_section( 'bender_analytics' ,
		// 	array(
		// 		'priority'    => 10,
		// 		'title'       => esc_html__( 'Analytics', 'bender' ),
		// 		'description' => '',
		// 		'panel'       => 'bender_options',
		// 	)
		// );
		
		// 	$wp_customize->add_setting( 'bender_analytics_google',
		// 		array(
		// 			'sanitize_callback' => 'esc_textarea',
		// 			'default'           => '',
		// 		)
		// 	);
		// 	$wp_customize->add_control( 'bender_analytics_google',
		// 		array(
		// 			'label'       => esc_html__('Google Analytics', 'bender'),
		// 			'section'     => 'bender_analytics',
		// 			'description' => 'Enter your Google Anayltics code below to track visitors to your site.', 
		// 			'type'        => 'textarea',
		// 		)
		// 	);
		/* Newsletter Settings
		----------------------------------------------------------------------*/
		$wp_customize->add_section( 'bender_newsletter' ,
			array(
				'priority'    => 9,
				'title'       => esc_html__( 'Newsletter', 'bender' ),
				'description' => '',
				'panel'       => 'bender_options',
			)
		);
			// Disable Newsletter
			$wp_customize->add_setting( 'bender_newsletter_disable',
				array(
					'sanitize_callback' => 'bender_sanitize_checkbox',
					'default'           => '1',
				)
			);
			$wp_customize->add_control( 'bender_newsletter_disable',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide Footer Newsletter?', 'bender'),
					'section'     => 'bender_newsletter',
					'description' => esc_html__('Check this box to hide footer newsletter form.', 'bender')
				)
			);

			// Mailchimp Form Title
			$wp_customize->add_setting( 'bender_newsletter_title',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => esc_html__( 'Join our Newsletter', 'bender' ),
				)
			);
			$wp_customize->add_control( 'bender_newsletter_title',
				array(
					'label'       => esc_html__('Newsletter Form Title', 'bender'),
					'section'     => 'bender_newsletter',
					'description' => ''
				)
			);

			// Mailchimp action url
			$wp_customize->add_setting( 'bender_newsletter_mailchimp',
				array(
					'sanitize_callback' => 'esc_url',
					'default'           => '',
				)
			);
			$wp_customize->add_control( 'bender_newsletter_mailchimp',
				array(
					'label'       => esc_html__('MailChimp Action URL', 'bender'),
					'section'     => 'bender_newsletter',
					'description' => 'The newsletter form use MailChimp, please follow <a target="_blank" href="http://goo.gl/uRVIst">this guide</a> to know how to get MailChimp Action URL. Example <i>//famethemes.us8.list-manage.com/subscribe/post?u=521c400d049a59a4b9c0550c2&amp;id=83187e0006</i>'
				)
			);

	/*------------------------------------------------------------------------*/
    /*  Section: Order & Styling
    /*------------------------------------------------------------------------*/
	$wp_customize->add_section( 'bender_order_styling' ,
		array(
			'priority'        => 129,
			'title'           => esc_html__( 'Section Order & Styling', 'bender' ),
			'description'     => '',
			'active_callback' => 'bender_showon_frontpage'
		)
	);
		// Plus message
		$wp_customize->add_setting( 'bender_order_styling_message',
			array(
				'sanitize_callback' => 'bender_sanitize_text',
			)
		);
		$wp_customize->add_control( new bender_Misc_Control( $wp_customize, 'bender_order_styling_message',
			array(
				'section'     => 'bender_news_settings',
				'type'        => 'custom_message',
				'section'     => 'bender_order_styling',
				'description' => wp_kses_post( '', 'bender' )
				// 'description' => wp_kses_post( ' Check out <a target="_blank" href="https://www.famethemes.com/themes/bender/?utm_source=theme_customizer&utm_medium=text_link&utm_campaign=bender_customizer#get-started">bender Plus version</a> for full control over <strong>section order</strong> and <strong>section styling</strong>! ', 'bender' )
			)
		));


	/*------------------------------------------------------------------------*/
    /*  Section: Hero
    /*------------------------------------------------------------------------*/

	$wp_customize->add_panel( 'bender_hero_panel' ,
		array(
			'priority'        => 130,
			'title'           => esc_html__( 'Section: Hero', 'bender' ),
			'description'     => '',
			'active_callback' => 'bender_showon_frontpage'
		)
	);

		// Hero settings
		$wp_customize->add_section( 'bender_hero_settings' ,
			array(
				'priority'    => 3,
				'title'       => esc_html__( 'Hero Settings', 'bender' ),
				'description' => '',
				'panel'       => 'bender_hero_panel',
			)
		);

			// Show section
			$wp_customize->add_setting( 'bender_hero_disable',
				array(
					'sanitize_callback' => 'bender_sanitize_checkbox',
					'default'           => '',
				)
			);
			$wp_customize->add_control( 'bender_hero_disable',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide this section?', 'bender'),
					'section'     => 'bender_hero_settings',
					'description' => esc_html__('Check this box to hide this section.', 'bender'),
				)
			);
			// Section ID
			$wp_customize->add_setting( 'bender_hero_id',
				array(
					'sanitize_callback' => 'bender_sanitize_text',
					'default'           => esc_html__('hero', 'bender'),
				)
			);
			$wp_customize->add_control( 'bender_hero_id',
				array(
					'label' 		=> esc_html__('Section ID:', 'bender'),
					'section' 		=> 'bender_hero_settings',
					'description'   => 'The section id, we will use this for link anchor.'
				)
			);

			// Show hero full screen
			$wp_customize->add_setting( 'bender_hero_fullscreen',
				array(
					'sanitize_callback' => 'bender_sanitize_checkbox',
					'default'           => '',
				)
			);
			$wp_customize->add_control( 'bender_hero_fullscreen',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Make hero section full screen', 'bender'),
					'section'     => 'bender_hero_settings',
					'description' => esc_html__('Check this box to make hero section full screen.', 'bender'),
				)
			);

			// Hero content padding top
			$wp_customize->add_setting( 'bender_hero_pdtop',
				array(
					'sanitize_callback' => 'bender_sanitize_text',
					'default'           => esc_html__('10', 'bender'),
				)
			);
			$wp_customize->add_control( 'bender_hero_pdtop',
				array(
					'label'           => esc_html__('Padding Top:', 'bender'),
					'section'         => 'bender_hero_settings',
					'description'     => 'The hero content padding top in percent (%).',
					'active_callback' => 'bender_hero_fullscreen_callback'
				)
			);

			// Hero content padding bottom
			$wp_customize->add_setting( 'bender_hero_pdbotom',
				array(
					'sanitize_callback' => 'bender_sanitize_text',
					'default'           => esc_html__('10', 'bender'),
				)
			);
			$wp_customize->add_control( 'bender_hero_pdbotom',
				array(
					'label'           => esc_html__('Padding Bottom:', 'bender'),
					'section'         => 'bender_hero_settings',
					'description'     => 'The hero content padding bottom in percent (%).',
					'active_callback' => 'bender_hero_fullscreen_callback'
				)
			);

		$wp_customize->add_section( 'bender_hero_images' ,
			array(
				'priority'    => 6,
				'title'       => esc_html__( 'Hero Background Media', 'bender' ),
				'description' => '',
				'panel'       => 'bender_hero_panel',
			)
		);


			$wp_customize->add_setting(
				'bender_hero_images',
				array(
					'sanitize_callback' => 'bender_sanitize_repeatable_data_field',
					'transport' => 'refresh', // refresh or postMessage
				) );

			$wp_customize->add_control(
				new bender_Customize_Repeatable_Control(
					$wp_customize,
					'bender_hero_images',
					array(
						'label'     => esc_html__('Background Images', 'bender'),
						'description'   => '',
						'priority'     => 40,
						'section'       => 'bender_hero_images',
						'title_format'  => esc_html__( 'Background', 'bender'), // [live_title]
						'max_item'      => 10, // Maximum item can add

						'fields'    => array(
							'image' => array(
								'title' => esc_html__('Background Image', 'bender'),
								'type'  =>'media',
								'default' => array(
									'url' => get_template_directory_uri().'/assets/images/hero5.jpg',
									'id' => ''
								)
							),

						),

					)
				)
			);

			// Overlay color
			$wp_customize->add_setting( 'bender_hero_overlay_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default'           => '#000000',
					'transport' => 'refresh', // refresh or postMessage
				)
			);
			$wp_customize->add_control( new WP_Customize_Color_Control(
					$wp_customize,
					'bender_hero_overlay_color',
					array(
						'label' 		=> esc_html__('Background Overlay Color', 'bender'),
						'section' 		=> 'bender_hero_images',
						'priority'      => 130,
					)
				)
			);


            // Parallax
            $wp_customize->add_setting( 'bender_hero_parallax',
                array(
                    'sanitize_callback' => 'bender_sanitize_checkbox',
                    'default'           => 0,
                    'transport' => 'refresh', // refresh or postMessage
                )
            );
            $wp_customize->add_control(
                'bender_hero_parallax',
                array(
                    'label' 		=> esc_html__('Enable parallax effect (apply for first BG image only)', 'bender'),
                    'section' 		=> 'bender_hero_images',
                    'type' 		   => 'checkbox',
                    'priority'      => 50,
                    'description' => '',
                )
            );

			// Overlay Opacity
			$wp_customize->add_setting( 'bender_hero_overlay_opacity',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => '0.3',
					'transport' => 'refresh', // refresh or postMessage
				)
			);
			$wp_customize->add_control(
					'bender_hero_overlay_opacity',
					array(
						'label' 		=> esc_html__('Background Overlay Opacity', 'bender'),
						'section' 		=> 'bender_hero_images',
						'description'   => esc_html__('Enter a float number between 0.1 to 0.9', 'bender'),
						'priority'      => 130,
					)
			);

			// Background Video
			$wp_customize->add_setting( 'bender_hero_videobackground_upsell',
				array(
					'sanitize_callback' => 'bender_sanitize_text',
				)
			);
			$wp_customize->add_control( new bender_Misc_Control( $wp_customize, 'bender_hero_videobackground_upsell',
				array(
					'section'     => 'bender_hero_images',
					'type'        => 'custom_message',
					'description' => wp_kses_post( '', 'bender' ),
					// 'description' => wp_kses_post( 'Want to add <strong>background video</strong> for hero section? Upgrade to <a target="_blank" href="https://www.famethemes.com/themes/bender/?utm_source=theme_customizer&utm_medium=text_link&utm_campaign=bender_customizer#get-started">bender Plus</a> version.', 'bender' ),
					'priority'    => 131,
				)
			));




		$wp_customize->add_section( 'bender_hero_content_layout1' ,
			array(
				'priority'    => 9,
				'title'       => esc_html__( 'Hero Content Layout #1', 'bender' ),
				'description' => '',
				'panel'       => 'bender_hero_panel',

			)
		);

			// Show Content
			$wp_customize->add_setting( 'bender_hcl1_enable',
				array(
					'sanitize_callback' => 'bender_sanitize_checkbox',
					'default'           => 1,
				)
			);
			$wp_customize->add_control( 'bender_hcl1_enable',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Show this content layout', 'bender'),
					'section'     => 'bender_hero_content_layout1',
					'description' => esc_html__('Check this box to enable this content layout for hero section.', 'bender'),
				)
			);

			// Large Text
			$wp_customize->add_setting( 'bender_hcl1_largetext',
				array(
					'sanitize_callback' => 'bender_sanitize_text',
					'default'           => wp_kses_post('We are <span class="js-rotating">bender | One Page | Responsive | Perfection</span>', 'bender'),
				)
			);
			$wp_customize->add_control( new One_Press_Textarea_Custom_Control(
				$wp_customize,
				'bender_hcl1_largetext',
				array(
					'label' 		=> esc_html__('Large Text', 'bender'),
					'section' 		=> 'bender_hero_content_layout1',
					'description'   => esc_html__('Text Rotating Guide: Put your rotate texts separate by "|" into <span class="js-rotating">...</span>, go to Customizer->Site Option->Animate to control rotate animation.', 'bender'),
				)
			));

			// Small Text
			$wp_customize->add_setting( 'bender_hcl1_smalltext',
				array(
					'sanitize_callback' => 'bender_sanitize_text',
					'default'			=> wp_kses_post('Morbi tempus porta nunc <strong>pharetra quisque</strong> ligula imperdiet posuere<br> vitae felis proin sagittis leo ac tellus blandit sollicitudin quisque vitae placerat.', 'bender'),
				)
			);
			$wp_customize->add_control( new One_Press_Textarea_Custom_Control(
				$wp_customize,
				'bender_hcl1_smalltext',
				array(
					'label' 		=> esc_html__('Small Text', 'bender'),
					'section' 		=> 'bender_hero_content_layout1',
					'description'   => esc_html__('You can use text rotate slider in this textarea too.', 'bender'),
				)
			));

			// Button #1 Text
			$wp_customize->add_setting( 'bender_hcl1_btn1_text',
				array(
					'sanitize_callback' => 'bender_sanitize_text',
					'default'           => esc_html__('About Us', 'bender'),
				)
			);
			$wp_customize->add_control( 'bender_hcl1_btn1_text',
				array(
					'label' 		=> esc_html__('Button #1 Text', 'bender'),
					'section' 		=> 'bender_hero_content_layout1'
				)
			);

			// Button #1 Link
			$wp_customize->add_setting( 'bender_hcl1_btn1_link',
				array(
					'sanitize_callback' => 'esc_url',
					'default'           => esc_url( home_url( '/' )).esc_html__('#about', 'bender'),
				)
			);
			$wp_customize->add_control( 'bender_hcl1_btn1_link',
				array(
					'label' 		=> esc_html__('Button #1 Link', 'bender'),
					'section' 		=> 'bender_hero_content_layout1'
				)
			);

			// Button #2 Text
			$wp_customize->add_setting( 'bender_hcl1_btn2_text',
				array(
					'sanitize_callback' => 'bender_sanitize_text',
					'default'           => esc_html__('Get Started', 'bender'),
				)
			);
			$wp_customize->add_control( 'bender_hcl1_btn2_text',
				array(
					'label' 		=> esc_html__('Button #2 Text', 'bender'),
					'section' 		=> 'bender_hero_content_layout1'
				)
			);

			// Button #2 Link
			$wp_customize->add_setting( 'bender_hcl1_btn2_link',
				array(
					'sanitize_callback' => 'esc_url',
					'default'           => esc_url( home_url( '/' )).esc_html__('#contact', 'bender'),
				)
			);
			$wp_customize->add_control( 'bender_hcl1_btn2_link',
				array(
					'label' 		=> esc_html__('Button #2 Link', 'bender'),
					'section' 		=> 'bender_hero_content_layout1'
				)
			);

	/*------------------------------------------------------------------------*/
	/*  Section: Video Popup
	/*------------------------------------------------------------------------*/
	$wp_customize->add_panel( 'bender_videolightbox' ,
		array(
			'priority'        => 132,
			'title'           => esc_html__( 'Section: Video Lightbox', 'bender' ),
			'description'     => '',
			'active_callback' => 'bender_showon_frontpage'
		)
	);

    $wp_customize->add_section( 'bender_videolightbox_settings' ,
        array(
            'priority'    => 3,
            'title'       => esc_html__( 'Section Settings', 'bender' ),
            'description' => '',
            'panel'       => 'bender_videolightbox',
        )
    );

    // Show Content
    $wp_customize->add_setting( 'bender_videolightbox_disable',
        array(
            'sanitize_callback' => 'bender_sanitize_checkbox',
            'default'           => '',
        )
    );
    $wp_customize->add_control( 'bender_videolightbox_disable',
        array(
            'type'        => 'checkbox',
            'label'       => esc_html__('Hide this section?', 'bender'),
            'section'     => 'bender_videolightbox_settings',
            'description' => esc_html__('Check this box to hide this section.', 'bender'),
        )
    );

    // Section ID
    $wp_customize->add_setting( 'bender_videolightbox_id',
        array(
            'sanitize_callback' => 'bender_sanitize_text',
            'default'           => 'videolightbox',
        )
    );
    $wp_customize->add_control( 'bender_videolightbox_id',
        array(
            'label' 		=> esc_html__('Section ID:', 'bender'),
            'section' 		=> 'bender_videolightbox_settings',
            'description'   => esc_html__('The section id, we will use this for link anchor.', 'bender' )
        )
    );

    // Title
    $wp_customize->add_setting( 'bender_videolightbox_title',
        array(
            'sanitize_callback' => 'bender_sanitize_text',
            'default'           => '',
        )
    );

    $wp_customize->add_control( new One_Press_Textarea_Custom_Control(
        $wp_customize,
        'bender_videolightbox_title',
        array(
            'label'     	=>  esc_html__('Section heading', 'bender'),
            'section' 		=> 'bender_videolightbox_settings',
            'description'   => '',
        )
    ));

    // Video URL
    $wp_customize->add_setting( 'bender_videolightbox_url',
        array(
            'sanitize_callback' => 'esc_url_raw',
            'default'           => '',
        )
    );
    $wp_customize->add_control( 'bender_videolightbox_url',
        array(
            'label' 		=> esc_html__('Video url', 'bender'),
            'section' 		=> 'bender_videolightbox_settings',
            'description'   =>  esc_html__('Paste Youtube or Vimeo url here', 'bender'),
        )
    );

    // Parallax image
    $wp_customize->add_setting( 'bender_videolightbox_image',
        array(
            'sanitize_callback' => 'esc_url_raw',
            'default'           => '',
        )
    );
    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize,
        'bender_videolightbox_image',
        array(
            'label' 		=> esc_html__('Background image', 'bender'),
            'section' 		=> 'bender_videolightbox_settings',
        )
    ));



	/*------------------------------------------------------------------------*/
    /*  Section: About
    /*------------------------------------------------------------------------*/
    $wp_customize->add_panel( 'bender_about' ,
		array(
			'priority'        => 132,
			'title'           => esc_html__( 'Section: About', 'bender' ),
			'description'     => '',
			'active_callback' => 'bender_showon_frontpage'
		)
	);

	$wp_customize->add_section( 'bender_about_settings' ,
		array(
			'priority'    => 3,
			'title'       => esc_html__( 'Section Settings', 'bender' ),
			'description' => '',
			'panel'       => 'bender_about',
		)
	);

		// Show Content
		$wp_customize->add_setting( 'bender_about_disable',
			array(
				'sanitize_callback' => 'bender_sanitize_checkbox',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'bender_about_disable',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide this section?', 'bender'),
				'section'     => 'bender_about_settings',
				'description' => esc_html__('Check this box to hide this section.', 'bender'),
			)
		);

		// Section ID
		$wp_customize->add_setting( 'bender_about_id',
			array(
				'sanitize_callback' => 'bender_sanitize_text',
				'default'           => esc_html__('about', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_about_id',
			array(
				'label' 		=> esc_html__('Section ID:', 'bender'),
				'section' 		=> 'bender_about_settings',
				'description'   => 'The section id, we will use this for link anchor.'
			)
		);

		// Title
		$wp_customize->add_setting( 'bender_about_title',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('About Us', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_about_title',
			array(
				'label' 		=> esc_html__('Section Title', 'bender'),
				'section' 		=> 'bender_about_settings',
				'description'   => '',
			)
		);

		// Sub Title
		$wp_customize->add_setting( 'bender_about_subtitle',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('Section subtitle', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_about_subtitle',
			array(
				'label' 		=> esc_html__('Section Subtitle', 'bender'),
				'section' 		=> 'bender_about_settings',
				'description'   => '',
			)
		);

		// Description
		$wp_customize->add_setting( 'bender_about_desc',
			array(
				'sanitize_callback' => 'bender_sanitize_text',
				'default'           => '',
			)
		);
		$wp_customize->add_control( new One_Press_Textarea_Custom_Control(
			$wp_customize,
			'bender_about_desc',
			array(
				'label' 		=> esc_html__('About Section Description', 'bender'),
				'section' 		=> 'bender_about_content',
				'description'   => '',
			)
		));


	$wp_customize->add_section( 'bender_about_content' ,
		array(
			'priority'    => 6,
			'title'       => esc_html__( 'Section Content', 'bender' ),
			'description' => '',
			'panel'       => 'bender_about',
		)
	);

		// Order & Stlying
		$wp_customize->add_setting(
			'bender_about_boxes',
			array(
				//'default' => '',
				'sanitize_callback' => 'bender_sanitize_repeatable_data_field',
				'transport' => 'refresh', // refresh or postMessage
			) );


			$wp_customize->add_control(
				new bender_Customize_Repeatable_Control(
					$wp_customize,
					'bender_about_boxes',
					array(
						'label' 		=> esc_html__('About content page', 'bender'),
						'description'   => '',
						'section'       => 'bender_about_content',
						'live_title_id' => 'content_page', // apply for unput text and textarea only
						'title_format'  => esc_html__('[live_title]', 'bender'), // [live_title]
						'max_item'      => 50, // Maximum item can add
                        'limited_msg' 	=> wp_kses_post( '','bender' ),
                        // 'limited_msg' 	=> wp_kses_post( 'Upgrade to <a target="_blank" href="https://www.famethemes.com/themes/bender/?utm_source=theme_customizer&utm_medium=text_link&utm_campaign=bender_customizer#get-started">bender Plus</a> to be able to add more items and unlock other premium features!', 'bender' ),
						//'allow_unlimited' => false, // Maximum item can add

						'fields'    => array(
							'content_page'  => array(
								'title' => esc_html__('Select a page', 'bender'),
								'type'  =>'select',
								'options' => $option_pages
							),
							'hide_title'  => array(
								'title' => esc_html__('Hide item title', 'bender'),
								'type'  =>'checkbox',
							),
							'enable_link'  => array(
								'title' => esc_html__('Link to single page', 'bender'),
								'type'  =>'checkbox',
							),
						),

					)
				)
			);

            // About content source
            $wp_customize->add_setting( 'bender_about_content_source',
                array(
                    'sanitize_callback' => 'sanitize_text_field',
                    'default'           => 'content',
                )
            );

            $wp_customize->add_control( 'bender_about_content_source',
                array(
                    'label' 		=> esc_html__('Item content source', 'bender'),
                    'section' 		=> 'bender_about_content',
                    'description'   => '',
                    'type'          => 'select',
                    'choices'       => array(
                        'content' => esc_html__( 'Full Page Content', 'bender' ),
                        'excerpt' => esc_html__( 'Page Excerpt', 'bender' ),
                    ),
                )
            );

    /*------------------------------------------------------------------------*/
    /*  Section: Services
    /*------------------------------------------------------------------------*/
    $wp_customize->add_panel( 'bender_services' ,
		array(
			'priority'        => 134,
			'title'           => esc_html__( 'Section: Services', 'bender' ),
			'description'     => '',
			'active_callback' => 'bender_showon_frontpage'
		)
	);

	$wp_customize->add_section( 'bender_service_settings' ,
		array(
			'priority'    => 3,
			'title'       => esc_html__( 'Section Settings', 'bender' ),
			'description' => '',
			'panel'       => 'bender_services',
		)
	);

		// Show Content
		$wp_customize->add_setting( 'bender_services_disable',
			array(
				'sanitize_callback' => 'bender_sanitize_checkbox',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'bender_services_disable',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide this section?', 'bender'),
				'section'     => 'bender_service_settings',
				'description' => esc_html__('Check this box to hide this section.', 'bender'),
			)
		);

		// Section ID
		$wp_customize->add_setting( 'bender_services_id',
			array(
				'sanitize_callback' => 'bender_sanitize_text',
				'default'           => esc_html__('services', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_services_id',
			array(
				'label'     => esc_html__('Section ID:', 'bender'),
				'section' 		=> 'bender_service_settings',
				'description'   => 'The section id, we will use this for link anchor.'
			)
		);

		// Title
		$wp_customize->add_setting( 'bender_services_title',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('Our Services', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_services_title',
			array(
				'label'     => esc_html__('Section Title', 'bender'),
				'section' 		=> 'bender_service_settings',
				'description'   => '',
			)
		);

		// Sub Title
		$wp_customize->add_setting( 'bender_services_subtitle',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('Section subtitle', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_services_subtitle',
			array(
				'label'     => esc_html__('Section Subtitle', 'bender'),
				'section' 		=> 'bender_service_settings',
				'description'   => '',
			)
		);

	$wp_customize->add_section( 'bender_service_content' ,
		array(
			'priority'    => 6,
			'title'       => esc_html__( 'Section Content', 'bender' ),
			'description' => '',
			'panel'       => 'bender_services',
		)
	);

		// Section service content.
		$wp_customize->add_setting(
			'bender_services',
			array(
				'sanitize_callback' => 'bender_sanitize_repeatable_data_field',
				'transport' => 'refresh', // refresh or postMessage
			) );


		$wp_customize->add_control(
			new bender_Customize_Repeatable_Control(
				$wp_customize,
				'bender_services',
				array(
					'label'     	=> esc_html__('Service content', 'bender'),
					'description'   => '',
					'section'       => 'bender_service_content',
					'live_title_id' => 'content_page', // apply for unput text and textarea only
					'title_format'  => esc_html__('[live_title]', 'bender'), // [live_title]
					'max_item'      => 100, // Maximum item can add
                    'limited_msg' 	=> wp_kses_post( '', 'bender' ),
                    // 'limited_msg' 	=> wp_kses_post( 'Upgrade to <a target="_blank" href="https://www.famethemes.com/themes/bender/?utm_source=theme_customizer&utm_medium=text_link&utm_campaign=bender_customizer#get-started">bender Plus</a> to be able to add more items and unlock other premium features!', 'bender' ),

					'fields'    => array(
						'icon' => array(
							'title' => esc_html__('Custom icon', 'bender'),
							'type'  =>'text',
							'desc'  => sprintf( wp_kses_post('Paste your <a target="_blank" href="%1$s">Font Awesome</a> icon class name here.', 'bender'), 'http://fortawesome.github.io/Font-Awesome/icons/' ),
							'default' => esc_html__( 'gg', 'bender' ),
						),
						'content_page'  => array(
							'title' => esc_html__('Select a page', 'bender'),
							'type'  =>'select',
							'options' => $option_pages
						),
						'enable_link'  => array(
							'title' => esc_html__('Link to single page', 'bender'),
							'type'  =>'checkbox',
						),
					),

				)
			)
		);

	/*------------------------------------------------------------------------*/
    /*  Section: Counter
    /*------------------------------------------------------------------------*/
	$wp_customize->add_panel( 'bender_counter' ,
		array(
			'priority'        => 134,
			'title'           => esc_html__( 'Section: Counter', 'bender' ),
			'description'     => '',
			'active_callback' => 'bender_showon_frontpage'
		)
	);

	$wp_customize->add_section( 'bender_counter_settings' ,
		array(
			'priority'    => 3,
			'title'       => esc_html__( 'Section Settings', 'bender' ),
			'description' => '',
			'panel'       => 'bender_counter',
		)
	);
		// Show Content
		$wp_customize->add_setting( 'bender_counter_disable',
			array(
				'sanitize_callback' => 'bender_sanitize_checkbox',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'bender_counter_disable',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide this section?', 'bender'),
				'section'     => 'bender_counter_settings',
				'description' => esc_html__('Check this box to hide this section.', 'bender'),
			)
		);

		// Section ID
		$wp_customize->add_setting( 'bender_counter_id',
			array(
				'sanitize_callback' => 'bender_sanitize_text',
				'default'           => esc_html__('counter', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_counter_id',
			array(
				'label'     	=> esc_html__('Section ID:', 'bender'),
				'section' 		=> 'bender_counter_settings',
				'description'   => 'The section id, we will use this for link anchor.'
			)
		);

		// Title
		$wp_customize->add_setting( 'bender_counter_title',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('Our Numbers', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_counter_title',
			array(
				'label'     	=> esc_html__('Section Title', 'bender'),
				'section' 		=> 'bender_counter_settings',
				'description'   => '',
			)
		);

		// Sub Title
		$wp_customize->add_setting( 'bender_counter_subtitle',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('Section subtitle', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_counter_subtitle',
			array(
				'label'     	=> esc_html__('Section Subtitle', 'bender'),
				'section' 		=> 'bender_counter_settings',
				'description'   => '',
			)
		);

	$wp_customize->add_section( 'bender_counter_content' ,
		array(
			'priority'    => 6,
			'title'       => esc_html__( 'Section Content', 'bender' ),
			'description' => '',
			'panel'       => 'bender_counter',
		)
	);

	// Order & Styling
	$wp_customize->add_setting(
		'bender_counter_boxes',
		array(
			'sanitize_callback' => 'bender_sanitize_repeatable_data_field',
			'transport' => 'refresh', // refresh or postMessage
		) );


		$wp_customize->add_control(
			new bender_Customize_Repeatable_Control(
				$wp_customize,
				'bender_counter_boxes',
				array(
					'label'     	=> esc_html__('Counter content', 'bender'),
					'description'   => '',
					'section'       => 'bender_counter_content',
					'live_title_id' => 'title', // apply for unput text and textarea only
					'title_format'  => esc_html__('[live_title]', 'bender'), // [live_title]
					'max_item'      => 100, // Maximum item can add
                    'limited_msg' 	=> wp_kses_post( '', 'bender' ),
                    // 'limited_msg' 	=> wp_kses_post( 'Upgrade to <a target="_blank" href="https://www.famethemes.com/themes/bender/?utm_source=theme_customizer&utm_medium=text_link&utm_campaign=bender_customizer#get-started">bender Plus</a> to be able to add more items and unlock other premium features!', 'bender' ),
                    'fields'    => array(
						'title' => array(
							'title' => esc_html__('Title', 'bender'),
							'type'  =>'text',
							'desc'  => '',
							'default' => esc_html__( 'Your counter label', 'bender' ),
						),
						'number' => array(
							'title' => esc_html__('Number', 'bender'),
							'type'  =>'text',
							'default' => 99,
						),
						'unit_before'  => array(
							'title' => esc_html__('Before number', 'bender'),
							'type'  =>'text',
							'default' => '',
						),
						'unit_after'  => array(
							'title' => esc_html__('After number', 'bender'),
							'type'  =>'text',
							'default' => '',
						),
					),

				)
			)
		);

	/*------------------------------------------------------------------------*/
    /*  Section: Team
    /*------------------------------------------------------------------------*/
    $wp_customize->add_panel( 'bender_team' ,
		array(
			'priority'        => 136,
			'title'           => esc_html__( 'Section: Team', 'bender' ),
			'description'     => '',
			'active_callback' => 'bender_showon_frontpage'
		)
	);

	$wp_customize->add_section( 'bender_team_settings' ,
		array(
			'priority'    => 3,
			'title'       => esc_html__( 'Section Settings', 'bender' ),
			'description' => '',
			'panel'       => 'bender_team',
		)
	);

		// Show Content
		$wp_customize->add_setting( 'bender_team_disable',
			array(
				'sanitize_callback' => 'bender_sanitize_checkbox',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'bender_team_disable',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide this section?', 'bender'),
				'section'     => 'bender_team_settings',
				'description' => esc_html__('Check this box to hide this section.', 'bender'),
			)
		);
		// Section ID
		$wp_customize->add_setting( 'bender_team_id',
			array(
				'sanitize_callback' => 'bender_sanitize_text',
				'default'           => esc_html__('team', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_team_id',
			array(
				'label'     	=> esc_html__('Section ID:', 'bender'),
				'section' 		=> 'bender_team_settings',
				'description'   => 'The section id, we will use this for link anchor.'
			)
		);

		// Title
		$wp_customize->add_setting( 'bender_team_title',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('Our Team', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_team_title',
			array(
				'label'    		=> esc_html__('Section Title', 'bender'),
				'section' 		=> 'bender_team_settings',
				'description'   => '',
			)
		);

		// Sub Title
		$wp_customize->add_setting( 'bender_team_subtitle',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('Section subtitle', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_team_subtitle',
			array(
				'label'     => esc_html__('Section Subtitle', 'bender'),
				'section' 		=> 'bender_team_settings',
				'description'   => '',
			)
		);

        // Team layout
        $wp_customize->add_setting( 'bender_team_layout',
            array(
                'sanitize_callback' => 'sanitize_text_field',
                'default'           => '3',
            )
        );

        $wp_customize->add_control( 'bender_team_layout',
            array(
                'label' 		=> esc_html__('Team Layout Setting', 'bender'),
                'section' 		=> 'bender_team_settings',
                'description'   => '',
                'type'          => 'select',
                'choices'       => array(
                    '3' => esc_html__( '4 Columns', 'bender' ),
                    '4' => esc_html__( '3 Columns', 'bender' ),
                    '6' => esc_html__( '2 Columns', 'bender' ),
                ),
            )
        );

	$wp_customize->add_section( 'bender_team_content' ,
		array(
			'priority'    => 6,
			'title'       => esc_html__( 'Section Content', 'bender' ),
			'description' => '',
			'panel'       => 'bender_team',
		)
	);

		// Team member settings
		$wp_customize->add_setting(
			'bender_team_members',
			array(
				'sanitize_callback' => 'bender_sanitize_repeatable_data_field',
				'transport' => 'refresh', // refresh or postMessage
			) );


		$wp_customize->add_control(
			new bender_Customize_Repeatable_Control(
				$wp_customize,
				'bender_team_members',
				array(
					'label'     => esc_html__('Team members', 'bender'),
					'description'   => '',
					'section'       => 'bender_team_content',
					//'live_title_id' => 'user_id', // apply for unput text and textarea only
					'title_format'  => esc_html__( '[live_title]', 'bender'), // [live_title]
					'max_item'      => 100, // Maximum item can add
                    'limited_msg' 	=> wp_kses_post( '', 'bender' ),
                    // 'limited_msg' 	=> wp_kses_post( 'Upgrade to <a target="_blank" href="https://www.famethemes.com/themes/bender/?utm_source=theme_customizer&utm_medium=text_link&utm_campaign=bender_customizer#get-started">bender Plus</a> to be able to add more items and unlock other premium features!', 'bender' ),

                    'fields'    => array(
						'user_id' => array(
							'title' => esc_html__('User media', 'bender'),
							'type'  =>'media',
							'desc'  => '',
						),
					),

				)
			)
		);

	/*------------------------------------------------------------------------*/
    /*  Section: News
    /*------------------------------------------------------------------------*/
    $wp_customize->add_panel( 'bender_news' ,
		array(
			'priority'        => 138,
			'title'           => esc_html__( 'Section: News', 'bender' ),
			'description'     => '',
			'active_callback' => 'bender_showon_frontpage'
		)
	);

	$wp_customize->add_section( 'bender_news_settings' ,
		array(
			'priority'    => 3,
			'title'       => esc_html__( 'Section Settings', 'bender' ),
			'description' => '',
			'panel'       => 'bender_news',
		)
	);

		// Show Content
		$wp_customize->add_setting( 'bender_news_disable',
			array(
				'sanitize_callback' => 'bender_sanitize_checkbox',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'bender_news_disable',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide this section?', 'bender'),
				'section'     => 'bender_news_settings',
				'description' => esc_html__('Check this box to hide this section.', 'bender'),
			)
		);

		// Section ID
		$wp_customize->add_setting( 'bender_news_id',
			array(
				'sanitize_callback' => 'bender_sanitize_text',
				'default'           => esc_html__('news', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_news_id',
			array(
				'label'     => esc_html__('Section ID:', 'bender'),
				'section' 		=> 'bender_news_settings',
				'description'   => 'The section id, we will use this for link anchor.'
			)
		);

		// Title
		$wp_customize->add_setting( 'bender_news_title',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('Latest News', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_news_title',
			array(
				'label'     => esc_html__('Section Title', 'bender'),
				'section' 		=> 'bender_news_settings',
				'description'   => '',
			)
		);

		// Sub Title
		$wp_customize->add_setting( 'bender_news_subtitle',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('Section subtitle', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_news_subtitle',
			array(
				'label'     => esc_html__('Section Subtitle', 'bender'),
				'section' 		=> 'bender_news_settings',
				'description'   => '',
			)
		);

		// hr
		$wp_customize->add_setting( 'bender_news_settings_hr',
			array(
				'sanitize_callback' => 'bender_sanitize_text',
			)
		);
		$wp_customize->add_control( new bender_Misc_Control( $wp_customize, 'bender_news_settings_hr',
			array(
				'section'     => 'bender_news_settings',
				'type'        => 'hr'
			)
		));

		// Number of post to show.
		$wp_customize->add_setting( 'bender_news_number',
			array(
				'sanitize_callback' => 'bender_sanitize_number',
				'default'           => '3',
			)
		);
		$wp_customize->add_control( 'bender_news_number',
			array(
				'label'     	=> esc_html__('Number of post to show', 'bender'),
				'section' 		=> 'bender_news_settings',
				'description'   => '',
			)
		);

		// Blog Button
		$wp_customize->add_setting( 'bender_news_more_link',
			array(
				'sanitize_callback' => 'esc_url',
				'default'           => '#',
			)
		);
		$wp_customize->add_control( 'bender_news_more_link',
			array(
				'label'       => esc_html__('More News button link', 'bender'),
				'section'     => 'bender_news_settings',
				'description' => 'It should be your blog page link.'
			)
		);
		$wp_customize->add_setting( 'bender_news_more_text',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('Read Our Blog', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_news_more_text',
			array(
				'label'     	=> esc_html__('Section Subtitle', 'bender'),
				'section' 		=> 'bender_news_settings',
				'description'   => '',
			)
		);

	/*------------------------------------------------------------------------*/
    /*  Section: Contact
    /*------------------------------------------------------------------------*/
    $wp_customize->add_panel( 'bender_contact' ,
		array(
			'priority'        => 140,
			'title'           => esc_html__( 'Section: Contact', 'bender' ),
			'description'     => '',
			'active_callback' => 'bender_showon_frontpage'
		)
	);

	$wp_customize->add_section( 'bender_contact_settings' ,
		array(
			'priority'    => 3,
			'title'       => esc_html__( 'Section Settings', 'bender' ),
			'description' => '',
			'panel'       => 'bender_contact',
		)
	);

		// Show Content
		$wp_customize->add_setting( 'bender_contact_disable',
			array(
				'sanitize_callback' => 'bender_sanitize_checkbox',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'bender_contact_disable',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide this section?', 'bender'),
				'section'     => 'bender_contact_settings',
				'description' => esc_html__('Check this box to hide this section.', 'bender'),
			)
		);

		// Section ID
		$wp_customize->add_setting( 'bender_contact_id',
			array(
				'sanitize_callback' => 'bender_sanitize_text',
				'default'           => esc_html__('contact', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_contact_id',
			array(
				'label'     => esc_html__('Section ID:', 'bender'),
				'section' 		=> 'bender_contact_settings',
				'description'   => 'The section id, we will use this for link anchor.'
			)
		);

		// Title
		$wp_customize->add_setting( 'bender_contact_title',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('Get in touch', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_contact_title',
			array(
				'label'     => esc_html__('Section Title', 'bender'),
				'section' 		=> 'bender_contact_settings',
				'description'   => '',
			)
		);

		// Sub Title
		$wp_customize->add_setting( 'bender_contact_subtitle',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => esc_html__('Section subtitle', 'bender'),
			)
		);
		$wp_customize->add_control( 'bender_contact_subtitle',
			array(
				'label'     => esc_html__('Section Subtitle', 'bender'),
				'section' 		=> 'bender_contact_settings',
				'description'   => '',
			)
		);

	$wp_customize->add_section( 'bender_contact_content' ,
		array(
			'priority'    => 6,
			'title'       => esc_html__( 'Section Content', 'bender' ),
			'description' => '',
			'panel'       => 'bender_contact',
		)
	);
		// Contact form 7 guide.
		$wp_customize->add_setting( 'bender_contact_cf7_guide',
			array(
				'sanitize_callback' => 'bender_sanitize_text'
			)
		);
		$wp_customize->add_control( new bender_Misc_Control( $wp_customize, 'bender_contact_cf7_guide',
			array(
				'section'     => 'bender_contact_content',
				'type'        => 'custom_message',
				'description' => wp_kses_post( 'In order to display contact form please install <a target="_blank" href="https://wordpress.org/plugins/contact-form-7/">Contact Form 7</a> plugin and then copy the contact form shortcode and paste it here, the shortcode will be like this <code>[contact-form-7 id="xxxx" title="Example Contact Form"]</code>', 'bender' )
			)
		));

		// Contact Form 7 Shortcode
		$wp_customize->add_setting( 'bender_contact_cf7',
			array(
				'sanitize_callback' => 'bender_sanitize_text',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'bender_contact_cf7',
			array(
				'label'     	=> esc_html__('Contact Form 7 Shortcode.', 'bender'),
				'section' 		=> 'bender_contact_content',
				'description'   => '',
			)
		);

		// Show CF7
		$wp_customize->add_setting( 'bender_contact_cf7_disable',
			array(
				'sanitize_callback' => 'bender_sanitize_checkbox',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'bender_contact_cf7_disable',
			array(
				'type'        => 'checkbox',
				'label'       => esc_html__('Hide contact form completely.', 'bender'),
				'section'     => 'bender_contact_content',
				'description' => esc_html__('Check this box to hide contact form.', 'bender'),
			)
		);

		// Contact Text
		$wp_customize->add_setting( 'bender_contact_text',
			array(
				'sanitize_callback' => 'bender_sanitize_text',
				'default'           => '',
			)
		);
		$wp_customize->add_control( new One_Press_Textarea_Custom_Control(
			$wp_customize,
			'bender_contact_text',
			array(
				'label'     	=> esc_html__('Contact Text', 'bender'),
				'section' 		=> 'bender_contact_content',
				'description'   => '',
			)
		));

		// hr
		$wp_customize->add_setting( 'bender_contact_text_hr', array( 'sanitize_callback' => 'bender_sanitize_text' ) );
		$wp_customize->add_control( new bender_Misc_Control( $wp_customize, 'bender_contact_text_hr',
			array(
				'section'     => 'bender_contact_content',
				'type'        => 'hr'
			)
		));

		// Address Box
		$wp_customize->add_setting( 'bender_contact_address_title',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'bender_contact_address_title',
			array(
				'label'     	=> esc_html__('Contact Box Title', 'bender'),
				'section' 		=> 'bender_contact_content',
				'description'   => '',
			)
		);

		// Contact Text
		$wp_customize->add_setting( 'bender_contact_address',
			array(
				'sanitize_callback' => 'bender_sanitize_text',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'bender_contact_address',
			array(
				'label'     => esc_html__('Address', 'bender'),
				'section' 		=> 'bender_contact_content',
				'description'   => '',
			)
		);

		// Contact Phone
		$wp_customize->add_setting( 'bender_contact_phone',
			array(
				'sanitize_callback' => 'bender_sanitize_text',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'bender_contact_phone',
			array(
				'label'     	=> esc_html__('Phone', 'bender'),
				'section' 		=> 'bender_contact_content',
				'description'   => '',
			)
		);

		// Contact Email
		$wp_customize->add_setting( 'bender_contact_email',
			array(
				'sanitize_callback' => 'sanitize_email',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'bender_contact_email',
			array(
				'label'     	=> esc_html__('Email', 'bender'),
				'section' 		=> 'bender_contact_content',
				'description'   => '',
			)
		);

		// Contact Fax
		$wp_customize->add_setting( 'bender_contact_fax',
			array(
				'sanitize_callback' => 'bender_sanitize_text',
				'default'           => '',
			)
		);
		$wp_customize->add_control( 'bender_contact_fax',
			array(
				'label'     	=> esc_html__('Fax', 'bender'),
				'section' 		=> 'bender_contact_content',
				'description'   => '',
			)
		);

		/**
		 * Hook to add other customize
		 */
		do_action( 'bender_customize_after_register', $wp_customize );

}
add_action( 'customize_register', 'bender_customize_register' );


/*------------------------------------------------------------------------*/
/*  bender Sanitize Functions.
/*------------------------------------------------------------------------*/

function bender_sanitize_file_url( $file_url ) {
	$output = '';
	$filetype = wp_check_filetype( $file_url );
	if ( $filetype["ext"] ) {
		$output = esc_url( $file_url );
	}
	return $output;
}

function bender_hero_fullscreen_callback ( $control ) {
	if ( $control->manager->get_setting('bender_hero_fullscreen')->value() == '' ) {
        return true;
    } else {
        return false;
    }
}

function bender_sanitize_number( $input ) {
    return balanceTags( $input );
}

function bender_sanitize_hex_color( $color ) {
	if ( $color === '' ) {
		return '';
	}
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}
	return null;
}

function bender_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
		return 1;
    } else {
		return 0;
    }
}

function bender_sanitize_text( $string ) {
	return wp_kses_post( balanceTags( $string ) );
}

function bender_sanitize_html_input( $string ) {
	return wp_kses_allowed_html( $string );
}

function bender_showon_frontpage() {
	return is_page_template( 'template-frontpage.php' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function bender_customize_preview_js() {
	wp_enqueue_script( 'bender_customizer_liveview', get_template_directory_uri() . '/assets/js/customizer-liveview.js', array( 'customize-preview' ), '20130508', true );

}
add_action( 'customize_preview_init', 'bender_customize_preview_js' );



add_action( 'customize_controls_enqueue_scripts', 'opneress_customize_js_settings' );
function opneress_customize_js_settings(){
    if ( ! function_exists( 'bender_get_actions_required' ) ) {
        return;
    }
    $actions = bender_get_actions_required();
    $n = array_count_values( $actions );
    $number_action =  0;
    if ( $n && isset( $n['active'] ) ) {
        $number_action = $n['active'];
    }

    wp_localize_script( 'customize-controls', 'bender_customizer_settings', array(
        'number_action' => $number_action,
        'is_plus_activated' => class_exists( 'bender_PLus' ) ? 'y' : 'n',
        'action_url' => admin_url( 'themes.php?page=ft_bender&tab=actions_required' )
    ) );
}
