<?php
/**
 * Created by PhpStorm.
 * User: maximebriand
 * Date: 17/04/2019
 * Time: 20:16
 */
//TODO: add ob_start(); and ob_end(); dynamicaly thanks to the plugin.
//TODO: URL rewritting

class Front_page {

    private $i = 0;
    public function __construct()
    {
        add_action( 'template_redirect',  array($this, 'check_for_frontpage') );
        add_filter('the_content', array($this, 'check_for_frontpage')); //appeler cette fonction et récupérer le contenu ici !!!
    }

    public function check_custom_slug($content)  {
        if(isset($_GET['c']) && isset($_COOKIE["company"])){
            setcookie("company", $_GET['c']);
         }
        if(isset($_COOKIE["company"])) {
            $slug = $_COOKIE["company"];
            $clps = carbon_get_theme_option( 'clp-content' );

            for($this->i; $this->i < count($clps); $this->i++ ) {
                if ($clps[$this->i]['clp_text'] !== $slug) {
                    $content = $content;
                    return $content;
                } else {
                    $content = wpautop($clps[$this->i]['champ_riche']); //wpautop fix paragraph issue
                    return $content;
                    break;
                }
            }
        } else {
              return $content;
          }


  //retravailler la logique. il faut que le get soit toujours egale à un des éléments.
  /* if($_GET['c'] && $_COOKIE["company"] != $_GET['c']){
       var_dump('url différente de cookie'); die();
       setcookie("company", $_GET['c']);
   }
   if(isset($_COOKIE["company"]) && ($_COOKIE["company"] === carbon_get_theme_option( 'clp_text' )) ){
       display_custom_message();
   }*/

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



//FAIRE UNE LOOP AVEC UN INDEX ET REGARDER LEQUEL EST LE BON ET FONCTIONNER AVEC LE TALEAU ET I
