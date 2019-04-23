<?php
/**
 * Created by PhpStorm.
 * User: maximebriand
 * Date: 17/04/2019
 * Time: 20:16
 */
//TODO: URL rewritting

class Front_page {

    private $slug;
    public function __construct()
    {
        add_filter( 'redirect_canonical',  array($this, 'disable_canonical_redirect_for_front_page' ), 1);
        add_action('init', array($this, 'add_my_rewrite'), 10, 0);
        add_action( 'wp',  array($this, 'define_slug') );
        add_action( 'wp',  array($this, 'set_cookie') );
        add_filter('the_content', array($this, 'check_for_frontpage'));
    }

    public function disable_canonical_redirect_for_front_page ($redirect)
    {
        if ( is_front_page() || is_home() ) {
            $redirect = false;
        }
        return $redirect;
    }

    public function add_my_rewrite()
    {
        $page_on_front = get_option( 'page_on_front' );
        add_rewrite_rule('^welcome/(.*)/?', 'index.php?index.php?page_id=' . $page_on_front .'&welcome=$matches[1]', 'top');
        add_rewrite_tag('%welcome%','([^&]+)');
        flush_rewrite_rules();
    }

    public function define_slug(){
        global $wp_query;
        if(isset($wp_query->query_vars['welcome']))
        {
            $this->slug= $wp_query->query_vars['welcome'];
        }
    }

    public function set_cookie()
    {
        if(isset($this->slug) && !isset($_COOKIE['company'])){
            setcookie('company', $this->slug, time()+31556926, '/');
        }

        if(isset($this->slug) && isset($_COOKIE['company'])){
            if($this->slug != $_COOKIE['company'] ) {
                setcookie('company', $this->slug, time()+31556926, '/');
            }
        }
    }

    public function check_slug()
    {
        if($this->slug == NULL && isset($_COOKIE['company']))
        {
            $this->slug = $_COOKIE['company'];
        }
    }

    public function check_for_frontpage($content)
    {
        if ( is_front_page() || is_home() ) {
            $content = $this->check_custom_slug($content);
        }
        return $content;
    }

    public function check_custom_slug($content)
    {
        $this->check_slug();

        if($this->slug) {
            $clps = carbon_get_theme_option( 'clp-content' );

            for($i = 0; $i < count($clps); $i++ ) {
               if ($clps[$i]['clp_text'] !== $this->slug) {
                    $content = $content;
                } else {
                    $content = wpautop($clps[$i]['champ_riche']); //wpautop fix paragraph issue
                    return $content;
                    break;
                }
            }
      }
      return $content;
    }
}

new Front_page();

