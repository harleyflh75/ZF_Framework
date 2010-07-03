<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Zend_View_Helper_MainMenu
 *
 * @author Todd
 */
class Zend_View_Helper_Menu extends Zend_View_Helper_Abstract{

    public function menu($menu_category) {
        
        echo $this->action('nav', 'menus', null, array('menu' => $menu_category));
    }

}
?>
