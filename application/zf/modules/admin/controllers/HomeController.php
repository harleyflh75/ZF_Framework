<?php

class Admin_HomeController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->acl->allow('admin',null);
    }

    public function indexAction()
    {
        $model = new App_Model_Page();
        //$this->view->model = $model->getContent('4');
    }

}

