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
//require_once( 'wp-sass/wp-sass.php' );


if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});
	
	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/no-timber.html';
	});
	
	return;
}

//show_admin_bar( false );

function the_excerpt_max_charlength( $charlength ){
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		echo '[...]';
	} else {
		echo $excerpt;
	}
}


Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action( 'wp_footer', array( $this, 'register_styles' ) );
		add_filter( 'wp_default_scripts', array($this, 'isa_remove_jquery_migrate') );

		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'widgets_init', array( $this, 'add_widgets' ) );

		//add_action('upload_mimes', 'add_file_types_to_uploads');
		//add_action('wp_AJAX_svg_get_attachment_url', 'get_attachment_url_media_library');

		add_filter( 'shortcode_atts_wpcf7', array($this, 'custom_shortcode_atts_wpcf7_filter'), 10, 3 );

		add_filter( 'wpcf7_validate_text*', array($this, 'custom_text_validation_filter'), 20, 2 );

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
				'singular_name'      => 'Рацион', // название для одной записи этого типа
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
			'supports'            => array('title'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			'taxonomies'          => array(),
			'has_archive'         => false,
			'rewrite'             => true,
			'query_var'           => true
		) );

		register_post_type('reviews', array(
			'label'  => null,
			'labels' => array(
				'name'               => 'Отзывы', // основное название для типа записи
				'singular_name'      => 'Отзыв', // название для одной записи этого типа
				'add_new'            => 'Добавить отзыв', // для добавления новой записи
				'add_new_item'       => 'Добавление отзыва', // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => 'Редактирование отзыва', // для редактирования типа записи
				'new_item'           => 'Новый отзыв', // текст новой записи
				'view_item'          => 'Смотреть отзыв', // для просмотра записи этого типа.
				'search_items'       => 'Искать отзыв', // для поиска по этим типам записи
				'not_found'          => 'Не найдено отзывов', // если в результате поиска ничего не было найдено
				'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
				'parent_item_colon'  => '', // для родителей (у древовидных типов)
				'menu_name'          => 'Отзывы', // название меню
			),
			'description'         => '',
			'public'              => true,
			'hierarchical'        => false,
			'supports'            => array('title', 'editor', 'thumbnail'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			'taxonomies'          => array(),
			'has_archive'         => false,
			'rewrite'             => true,
			'query_var'           => true
		) );
	}

	function register_styles() {
		wp_enqueue_style( 'style', get_stylesheet_uri() );

		wp_enqueue_style( 'style-fonts', get_template_directory_uri() . '/static/build/fonts/connect-fonts.css' );

		wp_enqueue_style( 'style-sass-11', get_template_directory_uri() . '/static/src/sass/style.sass?ver=1.0.1' );

		// if( is_page_template('template-front-page.php') ) {
			
		// }
		wp_enqueue_style( 'owl-css', get_template_directory_uri() . '/static/build/css/vendor/carousel/carousel.css' );
	}

	function register_scripts() {
		wp_deregister_script('jquery');

		wp_enqueue_script( 'jquery', get_template_directory_uri() . '/static/build/js/libs.min.js', array(), '20151215', true );

		wp_enqueue_script( 'scripts', get_template_directory_uri() . '/static/build/js/jquery.main.js', array(), '20151215', true );

		wp_enqueue_script( 'vanilla-scripts', get_template_directory_uri() . '/static/build/js/vanilla.main.js', array(), '20151215', true );
	}

	function isa_remove_jquery_migrate($scripts) {
    if(!is_admin()) {
      $scripts->remove( 'jquery');
      $scripts->add( 'jquery', false, array( 'jquery-core' ), '1.12.4' );
    }
	}

	// function add_file_types_to_uploads($file_types){

 //    $new_filetypes = array();
 //    $new_filetypes['svg'] = 'image/svg+xml';
 //    $file_types = array_merge($file_types, $new_filetypes );

 //    return $file_types;
	// }

	function add_to_context( $context ) {
		$context['menu'] = new TimberMenu('menu-1');
		$context['menu_footer'] = new TimberMenu('menu-2');
		$context['site'] = $this;
		$context['widget_set_1'] = Timber::get_widgets('widget_1');
		$context['options'] = get_fields('option');
		//$context['logo'] = get_custom_logo();
		return $context;
	}

	function generate_menu() {
		add_theme_support( 'menus' );
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'proporion' ),
			'menu-2' => esc_html__( 'Footer', 'proporion' )
		) );
	}

	function add_widgets() {
		register_sidebar(array(
			'id'						=> 'widget_1',
	    'name' 					=> 'Сайдбар',
	    'before_widget' => '<div class="widget">',
	    'after_widget' 	=> '</div>',
	    'before_title' 	=> '<p class="widget__title">',
	    'after_title' 	=> '</p>',
	  ));
	}

	function custom_shortcode_atts_wpcf7_filter( $out, $pairs, $atts ) {
		$my_attr = 'button-hidden-text';

		if ( isset( $atts[$my_attr] ) ) {
				$out[$my_attr] = $atts[$my_attr];
		}

		return $out;
	}

	function custom_text_validation_filter( $result, $tag ) {
	    if ( 'your-name' == $tag->name ) {
	        // matches any utf words with the first not starting with a number
	        $re = '/^[^\p{N}][\p{L}]*/i';

	        if (!preg_match($re, $_POST['your-name'], $matches)) {
	            $result->invalidate($tag, "Некорректное имя." );
	        }
	    }

	    return $result;
	}

	function add_options_page() {
		acf_add_options_page();
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		//$twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}
}
new StarterSite();