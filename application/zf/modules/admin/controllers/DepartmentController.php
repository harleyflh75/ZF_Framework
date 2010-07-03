<?php

class Admin_DepartmentController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->acl->allow('admin',null);
    }

    public function indexAction()
    {
        $this->view->message = $this->_helper->flashMessenger->getMessages();
        $model = new App_Model_Departments();
        $this->view->model = $model->fetchAll();

    }
    public function addAction()
    {
        $request = $this->getRequest();
        $form    = new Admin_Form_Department_Add();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {

                $model = new App_Model_Departments();
                $model->addDepartment($form->getValues()) ;
                $this->_helper->flashMessenger->addMessage('Added') ;
                return $this->_redirect('/admin/department');
            }
        }

        $this->view->form = $form;

    }
    public function activeAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $content = new App_Model_Departments();
        $content->statusDepartment($id);

        return $this->_redirect('/admin/department');
    }
    public function editAction()
    {
        $request = $this->getRequest();
        $form    = new Admin_Form_Department_Edit();
        $id = (int) $this->getRequest()->getParam('id');
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {

                $model = new App_Model_Departments();
                $model->updateDepartment($form->getValues(),$id);
                $this->_helper->flashMessenger->addMessage('Edited') ;
                return $this->_redirect('/admin/department');
            }
        }
        if($id > 0) {
              $news = new App_Model_Departments();
              $ad = $news->fetchRow('id='.$id);
              $form->populate($ad->toArray());
          }
        $this->view->form = $form;
    }
}

