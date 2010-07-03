<?php

class HomeController extends Zend_Controller_Action {



    public function init() {
        $this->_helper->acl->allow(null);
        //$this->_helper->actionStack('application', 'menu','default');
    }

    public function indexAction() {
        $model = new App_Model_Page();
        $this->view->model = $model->getPage('home');
    }

}

