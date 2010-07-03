<?php

class PostsController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->acl->allow(null);
    }

    public function indexAction()
    {
        $model = new App_Model_Page();
        $this->view->model = $model->fetchRow(array("name ='News'",'active = 1'));

        $posts = new App_Model_Posts();
        $this->view->post = $posts->fetchAll(array('active=1'), array('created DESC','order'));
   
    }

    public function viewAction()
    {
        $title = $this->getRequest()->getParam('item');

        $model = new App_Model_Posts();
        $this->view->post = $model->fetchRow(array("title ='".$title."'"));

    }

}



