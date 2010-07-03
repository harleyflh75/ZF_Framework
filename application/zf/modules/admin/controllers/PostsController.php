<?php

class Admin_PostsController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->acl->allow('admin', null);
    }

    public function indexAction() {
        $this->view->message = $this->_helper->flashMessenger->getMessages();
        $model = new App_Model_Posts();
        $this->view->model = $model->fetchAll(null, array('created DESC', 'id DESC'));
    }

    public function addAction() {
        $form = new Admin_Form_Posts_Add();
        $model = new App_Model_Posts();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {

                $model->addPost($form->getValues());
                $this->_helper->flashMessenger->addMessage('Added');
                return $this->_redirect('/admin/posts');
            }
        }

        $this->view->form = $form;
    }

    public function activeAction() {
        $id = (int) $this->getRequest()->getParam('id');
        $content = new App_Model_Posts();
        $content->statusPost($id);

        return $this->_redirect('/admin/posts');
    }

    public function editAction() {

        $id = (int) $this->getRequest()->getParam('id');
        $form = new Admin_Form_Posts_Edit();
        $model = new App_Model_Posts();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {

                $model->updatePost($form->getValues(), $id);
                $this->_helper->flashMessenger->addMessage('Edited');
                return $this->_redirect('/admin/posts');
            }
        }
        if ($id > 0) {
            $posts = $model->fetchRow('id=' . $id);
            $form->populate($posts->toArray());
        }
        $this->view->form = $form;
    }

}

