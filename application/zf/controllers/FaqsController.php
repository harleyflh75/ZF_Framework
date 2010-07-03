<?php

class FaqsController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->acl->allow(null);
    }

    public function indexAction()
    {
        $model = new App_Model_Page();
        $this->view->model = $model->fetchRow(array("name ='faqs'",'active = 1'));

        $faqs = new App_Model_Faqs();
        $this->view->faqs = $faqs->fetchAll('active=1', 'order');
        
    }
    
}



