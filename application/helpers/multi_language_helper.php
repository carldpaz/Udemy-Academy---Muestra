<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* CodeIgniter
*
* An open source application development framework for PHP 5.1.6 or newer
*
* @package		CodeIgniter
* @author		ExpressionEngine Dev Team
* @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
* @license		http://codeigniter.com/user_guide/license.html
* @link		http://codeigniter.com
* @since		Version 1.0
* @filesource
*/

// This function helps us to get the translated phrase from the file. If it does not exist this function will save the phrase and by default it will have the same form as given
if ( ! function_exists('get_phrase'))
{
    function get_phrase($phrase = '') {
        $CI	=&	get_instance();
        $CI->load->database();
        $site_lang = $CI->session->userdata('site_lang');

        if(empty($site_lang)){
            $availableLanguages = $CI->crud_model->get_all_languages();
            $navigatorLang = empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? "" :substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            $langList = [
                'en' => 'english',
                'es' => 'spanish',
                'pt' => 'portuguese',
                'zh' => 'chinese'
            ];
            if(!empty($langList[$navigatorLang]) && in_array($langList[$navigatorLang], $availableLanguages)){
                $language_code = $langList[$navigatorLang];
            }else{
                $language_code = $CI->db->get_where('settings' , array('key' => 'language'))->row()->value;
            }

            //$language_code = empty($langList[$navigatorLang]) ? $CI->db->get_where('settings' , array('key' => 'language'))->row()->value : $langList[$navigatorLang];

            $CI->session->set_userdata('site_lang', $language_code);
        }else{
            $language_code = $site_lang;
        }
        /*$language_code = !empty($site_lang)
            ? $site_lang
            : $CI->db->get_where('settings' , array('key' => 'language'))->row()->value;*/
        //$language_code = 'spanish';

        $key = strtolower(preg_replace('/\s+/', '_', $phrase));
        $key = preg_replace('([^A-Za-z_])', '', $key);//Quitar caracteres especiales

        $langArray = openJSONFile($language_code);

        if (!array_key_exists($key, $langArray)){
            //Si no existe lo crea
            $langArray[$key] = ucfirst(str_replace('_', ' ', $key));
            $jsonData = json_encode($langArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            file_put_contents(APPPATH.'language/'.$language_code.'.json', stripslashes($jsonData));
        }

        return $langArray[$key];
    }
}

// This function helps us to decode the language json and return that array to us
if ( ! function_exists('openJSONFile'))
{
    function openJSONFile($code)
    {
        $jsonString = [];
        if (file_exists(APPPATH.'language/'.$code.'.json')) {
            $jsonString = file_get_contents(APPPATH.'language/'.$code.'.json');
            $jsonString = json_decode($jsonString, true);
        }
        return is_array($jsonString) ? $jsonString : [];
    }
}

// This function helps us to create a new json file for new language
if ( ! function_exists('saveDefaultJSONFile'))
{
    function saveDefaultJSONFile($language_code){
        $language_code = strtolower($language_code);
        if(file_exists(APPPATH.'language/'.$language_code.'.json')){
            $newLangFile 	= APPPATH.'language/'.$language_code.'.json';
            $enLangFile   = APPPATH.'language/english.json';
            copy($enLangFile, $newLangFile);
        }else {
            $fp = fopen(APPPATH.'language/'.$language_code.'.json', 'w');
            $newLangFile = APPPATH.'language/'.$language_code.'.json';
            $enLangFile   = APPPATH.'language/english.json';
            copy($enLangFile, $newLangFile);
            fclose($fp);
        }
    }
}

// This function helps us to update a phrase inside the language file.
if ( ! function_exists('saveJSONFile'))
{
    function saveJSONFile($language_code, $updating_key, $updating_value){
        $jsonString = [];
        if(file_exists(APPPATH.'language/'.$language_code.'.json')){
            $jsonString = file_get_contents(APPPATH.'language/'.$language_code.'.json');
            $jsonString = json_decode($jsonString, true);
            $jsonString[$updating_key] = $updating_value;
        }else {
            $jsonString[$updating_key] = $updating_value;
        }

        $jsonData = json_encode($jsonString, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        if(!empty($jsonData)){
            file_put_contents(APPPATH.'language/'.$language_code.'.json', stripslashes($jsonData));
        }

    }
}


// ------------------------------------------------------------------------
/* End of file language_helper.php */
/* Location: ./system/helpers/language_helper.php */
