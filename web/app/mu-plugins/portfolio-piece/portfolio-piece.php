<?php
/**
 * Plugin Name:     Portfolio Piece
 * Description:     Adds Projects Functionality
 * Author:          Zach Townsend
 * Author URI:      https://zachtownsend.net
 * Text Domain:     portfolio-piece
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Portfolio_Piece
 */

// Your code starts here.
require_once 'vendor/autoload.php';

add_action('init', 'add_portfolio_cpt');

/**
 * Define Projects CPT
 */
function add_portfolio_cpt()
{
	register_extended_post_type(
		'project',
		[
			'public'       => true,
			'show_in_rest' => true,
		],
		[
			'singular' => __( 'Project', 'portfolio-piece' ),
			'plural'   => __( 'Projects', 'portfolio-piece' ),
			'slug'     => 'project',
		]
	);

	register_extended_taxonomy(
		'project-client',
		'project',
		[
			'hierarchical' => false,
		],
		[
			'singular' => __( 'Client', 'portfolio-piece' ),
			'plural'   => __( 'Clients', 'portfolio-piece' ),
			'slug'     => 'project-client',
		]
	);

	register_extended_taxonomy(
		'project-type',
		'project',
		[
			'hierarchical' => false,
		],
		[
			'singular' => __( 'Project Type', 'portfolio-piece' ),
			'plural'   => __( 'Project Types', 'portfolio-piece' ),
			'slug'     => 'project-type',
		]
	);

	register_extended_taxonomy(
		'project-techonology',
		'project',
		[],
		[
			'singular' => __( 'Techonology', 'portfolio-piece' ),
			'plural'   => __( 'Techonologies', 'portfolio-piece' ),
			'slug'     => 'project-techonology',
		]
	);
}

add_action( 'plugins_loaded', 'add_custom_fields', 10000 );

/**
 * Add ACF Fields
 */
function add_custom_fields() {
	$project_content = acf_flexible_content(
		[
			'name'         => 'project-content',
			'label'        => 'Project Content',
			'button_label' => 'Add a page component',
			'layouts'      => [
				acf_layout(
					[
						'name'       => 'text-block',
						'label'      => __( 'Text Block', 'portfolio-piece' ),
						'sub_fields' => [
							acf_text(
								[
									'name'  => 'block-title',
									'label' => __( 'Block Title', 'portfolio-piece' ),
								]
							),
							acf_wysiwyg(
								[
									'name'         => 'text-block-content',
									'label'        => __( 'Text Block Content', 'portfolio-piece' ),
									'required'     => true,
									'media_upload' => true,
								]
							),
						],
					]
				),
				acf_layout(
					[
						'name'       => 'image-block',
						'label'      => __( 'Image Block', 'portfolio-piece' ),
						'sub_fields' => [
							acf_image(
								[
									'name'         => 'image',
									'label'        => __( 'Image', 'portfolio-piece' ),
									'min_width'    => 1500,
									'preview_size' => 'large',
								]
							),
							acf_wysiwyg(
								[
									'name'         => 'text',
									'label'        => __( 'Text', 'portfolio-piece' ),
									'media_upload' => false,
								]
							),
						],
					]
				),
			],
		]
	);

	acf_field_group(
		[
			'title'    => __( 'Project Flexible Content', 'portfolio-piece' ),
			'fields'   => [ $project_content ],
			'style'    => 'seamless',
			'location' => [
				[
					acf_location( 'post_type', 'project' ),
				],
			],
		]
	);

	acf_field_group(
		[
			'title'  => __( 'Home Page Content', 'portfolio-piece' ),
			'fields' => [
				acf_text(
					[
						'name'  => 'title',
						'label' => 'Title',
					]
				),
			],
			'styles'   => 'seamless',
			'location' => [
				[
					acf_location( 'page_type', 'front_page' ),
				]
			],
			'hide_on_screen' => [
				'the_content',
			]
		]
	);
}
