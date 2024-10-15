<?php if ( ! defined('BASEPATH')) exit('Direct access allowed');

class Language extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }
    //http://localhost/cryptoacademy-udemy/language/switch_lang/english
    function switch_lang($language = "") {

        $language = ($language != "") ? $language : "english";

        $this->session->set_userdata('site_lang', $language);

        redirect($_SERVER['HTTP_REFERER']);

    }

}