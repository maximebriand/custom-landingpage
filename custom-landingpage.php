<?php
/**
Plugin Name: Custom Landing Page
 */
//TODO: create url rewritting https://codex.wordpress.org/Rewrite_API/add_rewrite_rule https://stackoverflow.com/questions/41021426/htaccess-rewrite-url-php-parameters
//TODO: make fields repeatable

namespace DMB\Plugin;
use Carbon_Fields\Field;
use Carbon_Fields\Container;
class customLandingPage {
    public function __construct()
    {
        if ( ! defined( 'ABSPATH' ) ) {
            exit;
        }

        add_action( 'after_setup_theme', array($this, 'load_carbonfields') );
        add_action( 'plugins_loaded', array($this, 'load_plugin' ));
        add_action( 'plugins_loaded', array($this, 'load_front_page' ));
    }

    /**
     * Charge notre dépendance Carbon Fields via Composer
     */
    public function load_carbonfields()
    {
        require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload.php';
        \Carbon_Fields\Carbon_Fields::boot();
    }

    public function load_plugin()
    {
        require_once plugin_dir_path( __FILE__ ) . '/includes/options.php';
    }

    public function load_front_page()
    {
        require_once plugin_dir_path( __FILE__ ) . '/includes/load_front_page.php';
    }

}


new customLandingPage();

