<?php

class Admin_LinksController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->acl->allow('admin', null);
    }

    public function indexAction() {
        $this->view->message = $this->_helper->flashMessenger->getMessages();
        $model = new App_Model_Links();
        $this->view->model = $model->fetchAll(null, 'order');
    }

    public function addAction() {
        $form = new Admin_Form_Links_Add();
        $model = new App_Model_Links();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {

                $model->addLinks($form->getValues());
                $this->_helper->flashMessenger->addMessage('Added');
                return $this->_redirect('/admin/links');
            }
        }

        $this->view->form = $form;
    }

    public function activeAction() {
        $id = (int) $this->getRequest()->getParam('id');
        $content = new App_Model_Links();
        $content->statusLinks($id);

        return $this->_redirect('/admin/links');
    }

    public function editAction() {
        
        $id = (int) $this->getRequest()->getParam('id');
        $form = new Admin_Form_Links_Edit();
        $model = new App_Model_Links();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {

                $model->updateLinks($form->getValues(), $id);
                $this->_helper->flashMessenger->addMessage('Edited');
                return $this->_redirect('/admin/links');
            }
        }
        if ($id > 0) {
            $links = $model->fetchRow('id=' . $id);
            $form->populate($links->toArray());
        }
        $this->view->form = $form;
    }

}

