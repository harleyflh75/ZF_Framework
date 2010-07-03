<?php

class VideoController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->acl->allow(null);
    }

    public function indexAction()
    {
        
        $this->view->video = 'test/redbelt.flv';

        
    }

}



