<?php
/* Gutenberg support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('themerex_gutenberg_theme_setup')) {
    add_action( 'themerex_action_before_init_theme', 'themerex_gutenberg_theme_setup', 1 );
    function themerex_gutenberg_theme_setup() {
        if (is_admin()) {
            add_filter( 'themerex_filter_required_plugins', 'themerex_gutenberg_required_plugins' );
        }
    }
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'themerex_exists_gutenberg' ) ) {
    function themerex_exists_gutenberg() {
        return function_exists( 'the_gutenberg_project' ) && function_exists( 'register_block_type' );
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'themerex_gutenberg_required_plugins' ) ) {
    function themerex_gutenberg_required_plugins($list=array()) {
        if (in_array('gutenberg', (array)themerex_get_global('required_plugins')))
            $list[] = array(
                'name'         => esc_html__('Gutenberg', 'education'),
                'slug'         => 'gutenberg',
                'required'     => false
            );
        return $list;
    }
}
?>