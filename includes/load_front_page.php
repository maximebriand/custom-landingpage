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
        add_action( 'init',  array($this, 'check_cookie') );
        add_filter('the_content', array($this, 'check_for_frontpage'));
    }


    public function check_cookie()  {
        if (!isset($_GET['c']) && isset($_COOKIE['company'])) {
            $this->slug = $_COOKIE['company'];
        }

        if(isset($_GET['c'])){
            setcookie("company", $_GET['c']);
            $this->slug = $_GET['c'];
        }
    }
    public function check_custom_slug($content)  {
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
      } return $content;
    }

    public function check_for_frontpage($content) {
        if ( is_front_page() || is_home() ) {
            $content = $this->check_custom_slug($content);
        }
        return $content;
    }

    public function display_custom_message($string )  {
        $clps = carbon_get_theme_option( 'clp-content' );
        $string = $clps[$this->i]['champ_riche'];
        return $string;
    }

}

new Front_page();

