<?php

/**
 * Plugins connect
 */
require get_template_directory() . '/tgm/connect.php';

/**
 * Theme functions
 */
require get_template_directory() . '/inc/theme-functions.php';


// Include the class (unless you are using the script as a plugin)
require_once( 'wp-sass/wp-sass.php' );

add_filter( 'shortcode_atts_wpcf7', 'custom_shortcode_atts_wpcf7_filter', 10, 3 );
 
function custom_shortcode_atts_wpcf7_filter( $out, $pairs, $atts ) {
  $my_attr = 'button-hidden-text';

  if ( isset( $atts[$my_attr] ) ) {
      $out[$my_attr] = $atts[$my_attr];
  }

  return $out;
}

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});
	
	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/no-timber.html';
	});
	
	return;
}



Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'post-thumbnails' );
		
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );

		add_filter('upload_mimes', array($this, 'cc_mime_types'));

		$this->add_options_page();

		$this->generate_menu();

		parent::__construct();
	}

	function register_post_types() {
		//this is where you can register custom post types

		register_post_type('rations', array(
			'label'  => null,
			'labels' => array(
				'name'               => 'Рационы', // основное название для типа записи
				'singular_name'      => 'ration', // название для одной записи этого типа
				'add_new'            => 'Добавить рацион', // для добавления новой записи
				'add_new_item'       => 'Добавление рациона', // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => 'Редактирование рациона', // для редактирования типа записи
				'new_item'           => 'Новый рацион', // текст новой записи
				'view_item'          => 'Смотреть рацион', // для просмотра записи этого типа.
				'search_items'       => 'Искать рацион', // для поиска по этим типам записи
				'not_found'          => 'Не найдено рациона', // если в результате поиска ничего не было найдено
				'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
				'parent_item_colon'  => '', // для родителей (у древовидных типов)
				'menu_name'          => 'Рационы', // название меню
			),
			'description'         => '',
			'public'              => true,
			'hierarchical'        => false,
			'supports'            => array('title','editor'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			'taxonomies'          => array(),
			'has_archive'         => false,
			'rewrite'             => true,
			'query_var'           => true
		) );
	}

	function register_scripts() {
		wp_enqueue_style( 'style', get_stylesheet_uri() );

		//wp_enqueue_style( 'style-sass-2', get_template_directory_uri() . '/style-sass.sass' );

		wp_enqueue_style( 'style-fonts', get_template_directory_uri() . '/static/src/fonts/connect-fonts.css' );

		wp_enqueue_style( 'style-sass-12', get_template_directory_uri() . '/static/src/sass/style.sass' );

		//wp_enqueue_style( 'css', get_template_directory_uri() . '/static/build/css/style.css' );

		if( is_page_template('template-front-page.php') ) {
			wp_enqueue_style( 'owl-css', get_template_directory_uri() . '/static/build/css/vendor/carousel/carousel.css' );
		}

		wp_enqueue_script( 'libs', get_template_directory_uri() . '/static/build/js/libs.min.js', array(), '20151215', true );

		wp_enqueue_script( 'scripts', get_template_directory_uri() . '/static/build/js/jquery.main.js', array(), '20151215', true );

		//wp_enqueue_script( 'vanilla-scripts', get_template_directory_uri() . '/assets/js/vanilla.main.js', array(), '20151215', true );
	}

	function cc_mime_types($mimes) {
	  $mimes['svg'] = 'image/svg+xml';
	  return $mimes;
	}

	function add_to_context( $context ) {
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;

		$context['options'] = get_fields('option');
		$context['logo'] = get_custom_logo();
		return $context;
	}

	function generate_menu() {
		add_theme_support( 'menus' );
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'videooperator' ),
		) );
	}

	function add_options_page() {
		acf_add_options_page();
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}

}

new StarterSite();
