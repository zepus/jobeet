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
        $text = preg_replace('/\W+/', '-', $text);
        $text = strtolower(trim($text, '-'));
        return $text;
    }
}

?>
