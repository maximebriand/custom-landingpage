<?php
/**
Plugin Name: Custom Landing Page
 */
//TODO: create url rewritting https://codex.wordpress.org/Rewrite_API/add_rewrite_rule https://stackoverflow.com/questions/41021426/htaccess-rewrite-url-php-parameters
//TODO: make fields repeatable

namespace DMB\Plugin;
use Carbon_Fields\Field;
use Carbon_Fields\Container;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Charge notre dépendance Carbon Fields via Composer
 */
function load_carbonfields() {
    require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload.php';
    \Carbon_Fields\Carbon_Fields::boot();
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\load_carbonfields' );
//add_action( 'after_setup_theme', [ Carbon_Fields::class, 'boot' ] );

/**
 * Charge notre fichier de plugin
 *
 * @return mixed
 */
function load_plugin() {
    require_once plugin_dir_path( __FILE__ ) . '/includes/options.php';
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_plugin' );

function load_front_page() {
    require_once plugin_dir_path( __FILE__ ) . '/includes/load_front_page.php';
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_front_page' );


