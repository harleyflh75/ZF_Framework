<?php

class LinksController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->acl->allow(null);
    }

    public function indexAction()
    {
        $model = new App_Model_Page();
        $this->view->model = $model->fetchRow(array("name ='links'",'active = 1'));

        $links = new App_Model_Links();
        $this->view->links = $links->fetchAll('active=1', 'order');
        
    }
    
}



