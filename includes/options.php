<?php
namespace DMB\Plugin\Options;



use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Créée une page d'options pour notre plugin.
 * Les onglets sont initialement vides mais sont définis et remplis de champs via des filtres définis plus bas.
 * TODO: regarder si je peux passer sans les tabs
 * @link https://carbonfields.net/docs/containers-theme-options/
 *
 * @return void
 */
function options_initialize_admin_page() {
	$tabs = apply_filters( 'clp_plugin_options_tabs', [] );

	if ( empty( $tabs ) ) {
		return;
	}
	$theme_options = Container::make( 'theme_options', __( 'Options du plugin', 'custom-landing-page-plugin' ) );
	$theme_options->set_page_file( 'custom_landing_page' );
	$theme_options->set_page_menu_title( __( 'Custom Landing Page', 'custom-landing-page-plugin' ) );
	$theme_options->set_page_menu_position( 100 );
	$theme_options->set_icon( 'dashicons-palmtree' ); //TODO: CHANGE THE LOGO

	// Et enfin, pour chaque onglet, on charge les champs de l'onglet concerné.
	foreach ( $tabs as $tab_slug => $tab_title ) {
		$theme_options->add_tab(
			esc_html( $tab_title ),
			apply_filters( "clp_plugin_options_fields_tab_{$tab_slug}", [] )
		);
	}
}
add_action( 'carbon_fields_register_fields', __NAMESPACE__ . '\\options_initialize_admin_page' );

/**
 * Liste des onglets dans lesquels seront rangés les champs de notre page d'options.
 *
 * @param array $tabs []
 * @return array $tabs Tableau des onglets : la clé d'une entrée est utilisée par le filtre chargeant les champs de l'onglet, la valeur d'une entrée est le titre de l'onglet.
 */
function options_set_tabs( $tabs ) {
	return [
		'general'  => __( 'Général', 'clp-plugin' )
	];
}
add_filter( 'clp_plugin_options_tabs', __NAMESPACE__ . '\\options_set_tabs' );

/**
 * Ajoute des champs dans l'onglet "Général".
 *
 * @return array $fields Le tableau contenant nos champs.
 * @link https://carbonfields.net/docs/fields-usage/
 */
function options_general_tab_theme_fields() {
	$fields = [];

    $fields[] = Field::make( 'complex', 'clp-content', 'Custom Landing Page' )
        ->set_layout( 'tabbed-horizontal' )
        ->add_fields( array(
            Field::make( 'text', 'clp_text', 'Paramètre de l\'URL' ),
            Field::make( 'rich_text', 'champ_riche', __( 'Champs WYSIWYG', 'clp-plugin' ) ),
        ) );


	return $fields;
}
add_filter( 'clp_plugin_options_fields_tab_general', __NAMESPACE__ . '\\options_general_tab_theme_fields', 10 );


