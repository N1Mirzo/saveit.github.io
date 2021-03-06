<?php
/* BB Press support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('themerex_bbpress_theme_setup')) {
	add_action( 'themerex_action_before_init_theme', 'themerex_bbpress_theme_setup' );
	function themerex_bbpress_theme_setup() {
		if (themerex_is_bbpress_page()) {
			add_action( 'themerex_action_add_styles', 'themerex_bbpress_frontend_scripts' );

			// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
			add_filter('themerex_filter_get_blog_type',				'themerex_bbpress_get_blog_type', 9, 2);
			add_filter('themerex_filter_get_blog_title',			'themerex_bbpress_get_blog_title', 9, 2);
			add_filter('themerex_filter_get_stream_page_title',		'themerex_bbpress_get_stream_page_title', 9, 2);
			add_filter('themerex_filter_get_stream_page_link',		'themerex_bbpress_get_stream_page_link', 9, 2);
			add_filter('themerex_filter_get_stream_page_id',		'themerex_bbpress_get_stream_page_id', 9, 2);
			add_filter('themerex_filter_detect_inheritance_key',	'themerex_bbpress_detect_inheritance_key', 9, 1);
		}
	}
}
if ( !function_exists( 'themerex_bbpress_settings_theme_setup2' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_bbpress_settings_theme_setup2', 3 );
	function themerex_bbpress_settings_theme_setup2() {
		if (themerex_exists_bbpress()) {
			themerex_add_theme_inheritance( array('bbpress' => array(
				'stream_template' => 'bbpress',
				'single_template' => '',
				'taxonomy' => array(),
				'taxonomy_tags' => array(),
				'post_type' => array('forum', 'topic'),
				'override' => 'page'
				) )
			);
		}
	}
}


// Check if BB Press installed and activated
if ( !function_exists( 'themerex_exists_bbpress' ) ) {
	function themerex_exists_bbpress() {
		return class_exists( 'bbPress' );
	}
}

// Check if current page is BB Press page
if ( !function_exists( 'themerex_is_bbpress_page' ) ) {
	function themerex_is_bbpress_page() {
		return function_exists('is_bbpress') && is_bbpress();
	}
}

// Filter to detect current page inheritance key
if ( !function_exists( 'themerex_bbpress_detect_inheritance_key' ) ) {
	function themerex_bbpress_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		return themerex_is_bbpress_page() ? 'bbpress' : '';
	}
}

// Filter to detect current page slug
if ( !function_exists( 'themerex_bbpress_get_blog_type' ) ) {
	function themerex_bbpress_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		if ($query && $query->get('post_type')=='forum' || get_query_var('post_type')=='forum')
			$page = 'bbpress_forum';
		else if ($query && $query->get('post_type')=='topic' || get_query_var('post_type')=='topic')
			$page = 'bbpress_topic';
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'themerex_bbpress_get_blog_title' ) ) {
	function themerex_bbpress_get_blog_title($title, $page) {
		if (!empty($title)) return $title;
		if ( themerex_strpos($page, 'bbpress')!==false ) {
			if ( $page == 'bbpress_forum' || $page == 'bbpress_topic' ) {
				$title = themerex_get_post_title();
			} else {
				$title = esc_html__('Forums', 'education');
			}
		}
		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'themerex_bbpress_get_stream_page_title' ) ) {
	function themerex_bbpress_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (themerex_strpos($page, 'bbpress')!==false) {

			// Page exists at root slug path, so use its permalink
			$page = bbp_get_page_by_path( bbp_get_root_slug() );
			if ( !empty( $page ) )
				$title = get_the_title( $page->ID );
			else
				$title = esc_html__('Forums', 'education');
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'themerex_bbpress_get_stream_page_id' ) ) {
	function themerex_bbpress_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (themerex_strpos($page, 'bbpress')!==false) {
			// Page exists at root slug path, so use its permalink
			$page = bbp_get_page_by_path( bbp_get_root_slug() );
			if ( !empty( $page ) ) $id = $page->ID;
		}
		return $id;
	}
}

// Filter to detect stream page URL
if ( !function_exists( 'themerex_bbpress_get_stream_page_link' ) ) {
	function themerex_bbpress_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (themerex_strpos($page, 'bbpress')!==false) {

			// Page exists at root slug path, so use its permalink
			$page = bbp_get_page_by_path( bbp_get_root_slug() );
			if ( !empty( $page ) )
				$url = get_permalink( $page->ID );
			else
				$url = get_post_type_archive_link( bbp_get_forum_post_type() );
		}
		return $url;
	}
}

// Enqueue BB Press custom styles
if ( !function_exists( 'themerex_bbpress_frontend_scripts' ) ) {
	function themerex_bbpress_frontend_scripts() {
		wp_enqueue_style( 'bbpress-style',  themerex_get_file_url('css/bbpress-style.css'), array(), null );
	}
}
?>