<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Jobeet
 *
 * @author Zepus
 */
class Jobeet {
    //put your code here
    static public function slugify($text) {
        
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);
        
        // trim
        $text = trim($text, '-');
        
        // transliteration
        if (function_exists('iconv')) {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }
        
        // lowercase
        $text = strtolower($text);
        
        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);
        
        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}

?>
