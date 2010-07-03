<?php

class PageController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->acl->allow(null);
    }

    public function indexAction() {
        $name = $this->getRequest()->getParam('title');

        $model = new App_Model_Page();
        $this->view->model = $model->fetchRow(array("name ='".$name."'",'active = 1'));
        if (!isset($this->view->model->id)) {
            $this->_redirect('/error/missing/title/'.$title);
            //$this->view->model = $model->fetchRow('id = 2');
        }
    }


}

