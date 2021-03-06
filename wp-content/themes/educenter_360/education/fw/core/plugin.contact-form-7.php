<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('themerex_contact_form_7_theme_setup')) {
    add_action( 'themerex_action_before_init_theme', 'themerex_contact_form_7_theme_setup', 1 );
    function themerex_contact_form_7_theme_setup() {
        if (is_admin()) {
            add_filter( 'themerex_filter_required_plugins', 'themerex_contact_form_7_required_plugins' );
        }
    }
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'themerex_exists_contact_form_7' ) ) {
    function themerex_exists_contact_form_7() {
        return class_exists('WPCF7') && class_exists('WPCF7_ContactForm');
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'themerex_contact_form_7_required_plugins' ) ) {
    function themerex_contact_form_7_required_plugins($list=array()) {
        if (in_array('contact-form-7', (array)themerex_get_global('required_plugins')))
            $list[] = array(
                'name'         => esc_html__('Contact Form 7', 'education'),
                'slug'         => 'contact-form-7',
                'required'     => false
            );
        return $list;
    }
}
?>