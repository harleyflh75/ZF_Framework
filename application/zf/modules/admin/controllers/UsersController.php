<?php

class Admin_UsersController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->acl->allow('admin',null);
    }

    public function indexAction()
    {
        $this->view->message = $this->_helper->flashMessenger->getMessages();
        $model = new App_Model_Users();
        $this->view->model = $model->fetchAll("role != 'super'");

    }
    public function addAction()
    {
        $request = $this->getRequest();
        $form    = new Admin_Form_Users_Add();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {

                $model = new App_Model_Users();
                $model->addUser($form->getValues()) ;
                $this->_helper->flashMessenger->addMessage('Added') ;
                return $this->_redirect('/admin/users');
            }
        }

        $this->view->form = $form;

    }
    public function activeAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $content = new App_Model_Users();
        $content->statusUser($id);

        return $this->_redirect('/admin/users');
    }
    public function editAction()
    {
        $request = $this->getRequest();
        $form    = new Admin_Form_Users_Edit();
        $id = (int) $this->getRequest()->getParam('id');
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {

                $model = new App_Model_Users();
                $model->updateUser($form->getValues(),$id);
                $this->_helper->flashMessenger->addMessage('Edited') ;
                return $this->_redirect('/admin/users');
            }
        }
        if($id > 0) {
              $news = new App_Model_Users();
              $ad = $news->fetchRow('id='.$id);
              $form->populate($ad->toArray());
          }
        $this->view->form = $form;
    }
}

