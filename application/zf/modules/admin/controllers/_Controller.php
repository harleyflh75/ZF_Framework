<?php

class Admin_XXXXXXXController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->acl->allow('admin', null);
    }

    public function indexAction() {
        $this->view->message = $this->_helper->flashMessenger->getMessages();
        $model = new App_Model_XXXXXXX();
        $this->view->model = $model->fetchAll(null, 'order');
    }

    public function addAction() {
        $form = new Admin_Form_XXXXXXX_Add();
        $model = new App_Model_XXXXXXX();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {

                $model->addXXXXXXX($form->getValues());
                $this->_helper->flashMessenger->addMessage('Added');
                return $this->_redirect('/admin/XXXXXXX');
            }
        }

        $this->view->form = $form;
    }

    public function activeAction() {
        $id = (int) $this->getRequest()->getParam('id');
        $content = new App_Model_XXXXXXX();
        $content->statusXXXXXXX($id);

        return $this->_redirect('/admin/XXXXXXX');
    }

    public function editAction() {
        
        $id = (int) $this->getRequest()->getParam('id');
        $form = new Admin_Form_XXXXXXX_Edit();
        $model = new App_Model_XXXXXXX();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {

                $model->updateXXXXXXX($form->getValues(), $id);
                $this->_helper->flashMessenger->addMessage('Edited');
                return $this->_redirect('/admin/XXXXXXX');
            }
        }
        if ($id > 0) {
            $XXXXXXX = $model->fetchRow('id=' . $id);
            $form->populate($XXXXXXX->toArray());
        }
        $this->view->form = $form;
    }

}

