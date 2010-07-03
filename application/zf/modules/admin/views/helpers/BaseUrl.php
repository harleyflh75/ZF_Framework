<?php

class Admin_View_Helper_BaseUrl
{
    public function baseUrl(){

        $fc = Zend_Controller_Front::getInstance();
        return $fc->getBaseUrl();
        
    }
}
