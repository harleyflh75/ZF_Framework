<?php

class Admin_NewsController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->acl->allow('admin', null);
    }

    public function indexAction() {
        $this->view->message = $this->_helper->flashMessenger->getMessages();
        $model = new App_Model_News();
        $this->view->model = $model->fetchAll(null, array('created DESC', 'id DESC'));
    }

    public function addAction() {
        $form = new Admin_Form_News_Add();
        $model = new App_Model_News();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {

                $model->addNews($form->getValues());
                $this->_helper->flashMessenger->addMessage('Added');
                return $this->_redirect('/admin/news');
            }
        }

        $this->view->form = $form;
    }

    public function activeAction() {
        $id = (int) $this->getRequest()->getParam('id');
        $content = new App_Model_News();
        $content->statusNews($id);

        return $this->_redirect('/admin/news');
    }

    public function editAction() {
        
        $id = (int) $this->getRequest()->getParam('id');
        $form = new Admin_Form_News_Edit();
        $model = new App_Model_News();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {

                $model->updateNews($form->getValues(), $id);
                $this->_helper->flashMessenger->addMessage('Edited');
                return $this->_redirect('/admin/news');
            }
        }
        if ($id > 0) {
            $news = $model->fetchRow('id=' . $id);
            $form->populate($news->toArray());
        }
        $this->view->form = $form;
    }

}

