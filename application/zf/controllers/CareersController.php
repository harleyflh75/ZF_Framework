<?php

class CareersController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->acl->allow(null);
    }

    public function indexAction()
    {
        $model = new App_Model_Page();
        $this->view->model = $model->fetchRow(array("name ='careers'",'active = 1'));

        $jobs = new App_Model_Careers();
        $this->view->jobs = $jobs->fetchAll('active=1', 'order');
        
    }
    public function viewAction(){
        $id = $this->getRequest()->getParam('job');

        $job = new App_Model_Careers();
        $this->view->job = $job->fetchRow(array("job_id = '". $id."'"));
    }
    public function applyAction(){
        $id = $this->getRequest()->getParam('job');

        $job = new App_Model_Careers();
        $this->view->job = $job->fetchRow(array("job_id = '". $id."'"));
    }
}



