<?php

function theme_support() {
	// adds dynamic title tag support
	add_theme_support( 'title-tag' );
	add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'theme_support');

function menus() {

	$locations = array(
		'primary' => "Desktop Primary Left Sidebar",
		'footer' => "Footer Menu Items",
        'main-menu' => 'Main menu location'
	);

	register_nav_menus($locations);
}

add_action('init','menus');

function addStyleSheets():void {

	# dynamic version handler, fetches version from style.css boilerplate
	$version = wp_get_theme()->get('Version');

	wp_enqueue_style('style', get_stylesheet_uri(), array('bootstrap'), $version, 'all');
	wp_enqueue_style('bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css", array(), $version, 'all');
	wp_enqueue_style('fontawesome', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css", array(), $version, 'all');

}

add_action('wp_enqueue_scripts', 'addStyleSheets');

function addRegisterScripts() {

	wp_enqueue_script('script-jquery', "https://code.jquery.com/jquery-3.4.1.slim.min.js", array(), '3.4.1',true);
	wp_enqueue_script('script-popper', "https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js", array(), '1.16.0',true);
	wp_enqueue_script('script-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js", array(), '4.4.1',true);
	wp_enqueue_script('script-main-js',get_template_directory_uri(). "/assets/js/main.js" , array(), '',true);

}

add_action('wp_enqueue_scripts', 'addRegisterScripts');

function configCustomLogo() {
	add_theme_support('custom-logo');
}

add_action('after_setup_theme', 'configCustomLogo');

function widgetAreas() {
	register_sidebar(
		array(
			'before_title' => '',
			'after_title' => '',
			'before_widget' => '<ul class="social-list list-inline py-3 mx-auto">',
			'after_widget' => '</ul>',
			'name' => 'Sidebar Area',
			'id' => 'sidebar-1',
			'description' => 'Sidebar Widget Area',
		)
	);

	register_sidebar(
		array(
			'before_title' => '',
			'after_title' => '',
			'before_widget' => '',
			'after_widget' => '',
			'name' => 'Footer Area',
			'id' => 'footer-1',
			'description' => 'Footer Widget Area',
		)
	);
}

add_action('widgets_init', 'widgetAreas');

/* Custom Post Type Start */
function create_posttype() {
    register_post_type( 'news',
        // CPT Options
        array(
            'labels' => array(
                'name' => __( 'news' ),
                'singular_name' => __( 'News' )
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'news'),
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );
/* Custom Post Type End */

/*Custom Post type start*/
function cw_post_type_news() {
    $supports = array(
        'title', // post title
        'editor', // post content
        'author', // post author
        'thumbnail', // featured images
        'excerpt', // post excerpt
        'custom-fields', // custom fields
        'comments', // post comments
        'revisions', // post revisions
        'post-formats', // post formats
    );
    $labels = array(
        'name' => _x('news', 'plural'),
        'singular_name' => _x('news', 'singular'),
        'menu_name' => _x('news', 'admin menu'),
        'name_admin_bar' => _x('news', 'admin bar'),
        'add_new' => _x('Add New', 'add new'),
        'add_new_item' => __('Add New news'),
        'new_item' => __('New news'),
        'edit_item' => __('Edit news'),
        'view_item' => __('View news'),
        'all_items' => __('All news'),
        'search_items' => __('Search news'),
        'not_found' => __('No news found.'),
    );
    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'news'),
        'has_archive' => true,
        'hierarchical' => false,
    );
    register_post_type('news', $args);
}
add_action('init', 'cw_post_type_news');
/*Custom Post type end*/