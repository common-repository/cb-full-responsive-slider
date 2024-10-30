<?php 
/*
Plugin Name: CB Full Responsive Slider
Plugin URI: http://www.codingbank.com/plugins/cb-full-responsive-slider
Description: This is full responsive slider for wordpress theme with shortcode support. shortcode is [cb_sliders].
Version: 1.1
Author: Md Abul Bashar
Author URI: http://www.codingbank.com/

*/


function cb_slider_custom_post() {
	register_post_type( 'sliders', 
			array(
			'labels' => array(
				'name' => __( 'Sliders', 'cb_slider' ),
				'singular_name' => __( 'Slider', 'cb_slider' ),
				'add_new' => __( 'Add New Slider', 'cb_slider' ),
				'add_new_item' => __( 'Add New Slider', 'cb_slider' ),
				'edit_item'		=> __('Edit Slider Info', 'cb_slider'),
				'view_item'		=> __('View Slider Info', 'cb_slider'), 				
				'not_found' => __( 'Sorry, we couldn\'t find the Slider you are looking for.', 'cb_slider' )
			),
			'public' => true,
			'menu_icon'	=> 'dashicons-admin-users',
			'supports' => array('title', 'custom-fields', 'thumbnail', 'editor'),
			'has_archive' => true,
			'rewrite' => array('slug' => 'slider'),
			'capability_type' => 'page', 
		)
	
	
	);
	
}
add_action('after_setup_theme', 'cb_slider_custom_post');

function cb_slider_normal_file(){
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-thumbnails', array( 'sliders' ) );  
	add_image_size( 'cb_slider_img', 1170, 300 );
	
}
add_action('after_setup_theme', 'cb_slider_normal_file');


function cb_slider_plugin_script(){
	
	wp_enqueue_style( 'pgwslider',  plugin_dir_url( __FILE__ ) . '/pgwslider.css', array(), '1.0' );
	
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'pgwslidermin',  plugin_dir_url( __FILE__ ) . '/pgwslider.min.js', array( 'jquery' ), '1.0', true );
	
	wp_enqueue_script( 'cb-slider-main',  plugin_dir_url( __FILE__ ) . '/cb-main.js', array( 'jquery' ), '1.0', true );
	
}
add_action('wp_enqueue_scripts', 'cb_slider_plugin_script');



//www.pchelpcenterbd.com
//www.linuxhostlab.com

function cb_slider_shortcode($atts){
	extract( shortcode_atts( array(
		'count' => 5,
		'posttype' => 'sliders',
	), $atts ) );
	
    $q = new WP_Query(
        array('posts_per_page' => $count, 'post_type' => $posttype)
        );		
		
		
	$list = '<ul class="pgwSlider">';
	while($q->have_posts()) : $q->the_post();
		$idd = get_the_ID();
		$cb_slider_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'cb_slider_img' );
		$list .= '
		<li><img src="'.$cb_slider_img[0].'" alt="'.get_the_title().'" data-description="'.get_the_content().'"></li>
		
		';        
	endwhile;
	$list.= '</ul>';
	wp_reset_query();
	return $list;
}
add_shortcode('cb_sliders', 'cb_slider_shortcode');	



?>