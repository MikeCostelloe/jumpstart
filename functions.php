<?php
/**
 * jumpstart functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package jumpstart
 */

if ( ! function_exists( 'jumpstart_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function jumpstart_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on jumpstart, use a find and replace
	 * to change 'jumpstart' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'jumpstart', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size('large-thumb', 1060, 650, true);
	add_image_size('index-thumb', 800, 250, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'jumpstart' ),
		'social' => __( 'Social Menu', 'jumpstart'),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'jumpstart_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // jumpstart_setup
add_action( 'after_setup_theme', 'jumpstart_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function jumpstart_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'jumpstart_content_width', 640 );
}
add_action( 'after_setup_theme', 'jumpstart_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function jumpstart_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'jumpstart' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
    'name'          => __( 'Footer Widgets', 'jumpstart' ),
    'description'   => __( 'Footer widgets area appears in the footer of the site.', 'jumpstart' ),
    'id'            => 'sidebar-2',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h1 class="widget-title">',
    'after_title'   => '</h1>',
) );
}
add_action( 'widgets_init', 'jumpstart_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function jumpstart_scripts() {
	//FontAwesome
	wp_enqueue_style( 'jumpstart-fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );

	wp_enqueue_style( 'jumpstart-style', get_stylesheet_uri() );
	//Layouts
	if (is_page_template('page-templates/page-full.php')) {
		wp_enqueue_style( 'jumpstart-layout-style' , get_template_directory_uri() . '/layouts/no-sidebar.css');
	} else {
		wp_enqueue_style( 'jumpstart-layout-style' , get_template_directory_uri() . '/layouts/content-sidebar.css');
	}

	wp_enqueue_script( 'jumpstart-vendor', get_template_directory_uri() . '/vendor.js', array('jquery'), '20151120', true );

	wp_enqueue_script( 'jumpstart-scripts', get_template_directory_uri() . '/scripts.js', array('jumpstart-vendor'), '20151120', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'jumpstart_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
