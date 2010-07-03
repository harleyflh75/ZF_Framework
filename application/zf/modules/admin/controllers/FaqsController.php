<?php

class Admin_FaqsController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->acl->allow('admin', null);
    }

    public function indexAction() {
        $this->view->message = $this->_helper->flashMessenger->getMessages();
        $model = new App_Model_Faqs();
        $this->view->model = $model->fetchAll(null, 'order');
    }

    public function addAction() {
        $form = new Admin_Form_Faqs_Add();
        $model = new App_Model_Faqs();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {

                $model->addFaqs($form->getValues());
                $this->_helper->flashMessenger->addMessage('Added');
                return $this->_redirect('/admin/faqs');
            }
        }

        $this->view->form = $form;
    }

    public function activeAction() {
        $id = (int) $this->getRequest()->getParam('id');
        $content = new App_Model_Faqs();
        $content->statusFaqs($id);

        return $this->_redirect('/admin/faqs');
    }

    public function editAction() {
        
        $id = (int) $this->getRequest()->getParam('id');
        $form = new Admin_Form_Faqs_Edit();
        $model = new App_Model_Faqs();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {

                $model->updateFaqs($form->getValues(), $id);
                $this->_helper->flashMessenger->addMessage('Edited');
                return $this->_redirect('/admin/faqs');
            }
        }
        if ($id > 0) {
            $faqs = $model->fetchRow('id=' . $id);
            $form->populate($faqs->toArray());
        }
        $this->view->form = $form;
    }

}

