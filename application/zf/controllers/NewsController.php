<?php

class NewsController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->acl->allow(null);
    }

    public function indexAction()
    {
        $model = new App_Model_Page();
        $this->view->model = $model->fetchRow(array("name ='news'",'active = 1'));

        $news = new App_Model_News();
        $this->view->news = $news->fetchAll(array('active=1'), array('created DESC','order'));
   
    }

    public function viewAction()
    {
        $title = $this->getRequest()->getParam('item');

        $model = new App_Model_News();
        $this->view->news = $model->fetchRow(array("title ='".$title."'"));

    }

}



