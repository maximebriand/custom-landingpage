<?php
namespace DMB\Plugin\Options;

use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;


class Options {
    private $theme_options;
    public function __construct()
    {
        add_action( 'carbon_fields_register_fields', array($this, 'options_initialize_admin_page') );
        add_action( 'carbon_fields_register_fields', array( $this, 'options_add_main_tab') );
        add_action( 'carbon_fields_register_fields', array( $this, 'options_add_custom_slug') );
    }

    public function options_initialize_admin_page() {
        $this->theme_options = Container::make( 'theme_options', __( 'Options du plugin', 'custom-landing-page-plugin' ) );
        $this->theme_options->set_page_file( 'custom_landing_page' );
        $this->theme_options->set_page_menu_title( __( 'Custom Landing Page', 'custom-landing-page-plugin' ) );
        $this->theme_options->set_page_menu_position( 100 );
        $this->theme_options->set_icon( 'dashicons-palmtree' ); //TODO: CHANGE THE LOGO
    }

    public function options_add_main_tab() {
        $this->theme_options->add_fields( array(
            Field::make( 'complex', 'clp_content', 'Custom Landing Page' )
                ->set_layout( 'tabbed-horizontal' )
                ->add_fields( array(
                    Field::make( 'text', 'clp_text', 'Paramètre de l\'URL' ),
                    Field::make( 'rich_text', 'champ_riche', __( 'Champs WYSIWYG', 'clp-plugin' ) ),
                ))
        ));
    }

    function options_add_custom_slug() {
        $this->theme_options->add_fields( array(
            Field::make( 'text', 'clp_url', 'Quel sera le paramètre statique de l\'URL, par exemple: mon-domaine.com/WELCOME/slug')
        ));
    }
}
new Options();
