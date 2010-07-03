<?php

class Admin_CareersController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->acl->allow('admin', null);
    }

    public function indexAction() {
        $this->view->message = $this->_helper->flashMessenger->getMessages();
        $model = new App_Model_Careers();
        $this->view->model = $model->fetchAll(null, 'order');
    }

    public function addAction() {
        $form = new Admin_Form_Careers_Add();
        $model = new App_Model_Careers();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {

                $model->addCareers($form->getValues());
                $this->_helper->flashMessenger->addMessage('Added');
                return $this->_redirect('/admin/careers');
            }
        }

        $this->view->form = $form;
    }

    public function activeAction() {
        $id = (int) $this->getRequest()->getParam('id');
        $content = new App_Model_Careers();
        $content->statusCareers($id);

        return $this->_redirect('/admin/careers');
    }

    public function editAction() {
        
        $id = (int) $this->getRequest()->getParam('id');
        $form = new Admin_Form_Careers_Edit();
        $model = new App_Model_Careers();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {

                $model->updateCareers($form->getValues(), $id);
                $this->_helper->flashMessenger->addMessage('Edited');
                return $this->_redirect('/admin/careers');
            }
        }
        if ($id > 0) {
            $careers = $model->fetchRow('id=' . $id);
            $form->populate($careers->toArray());
        }
        $this->view->form = $form;
    }

}

