<?php

/**
 * Plugins connect
 */
require get_template_directory() . '/tgm/connect.php';

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});
	
	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});
	
	return;
}



Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		//add_action( 'init', array( $this, 'register_post_types' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'seva_portfolio_scripts' ) );

		parent::__construct();
	}

	function register_post_types() {
		//this is where you can register custom post types
	}

	function register_scripts() {
		wp_enqueue_style( 'style', get_stylesheet_uri() );

		wp_enqueue_style( 'css', get_template_directory_uri() . '/assets/build/css/style.css' );

		//wp_enqueue_script( 'libs', get_template_directory_uri() . '/assets/js/libs.min.js', array(), '20151215', true );

		//wp_enqueue_script( 'jquery-scripts', get_template_directory_uri() . '/assets/js/jquery.main.js', array(), '20151215', true );

		//wp_enqueue_script( 'vanilla-scripts', get_template_directory_uri() . '/assets/js/vanilla.main.js', array(), '20151215', true );
	}

	function add_to_context( $context ) {
		$context['foo'] = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::get_context();';
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;
		return $context;
	}

	function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}

}

new StarterSite();
