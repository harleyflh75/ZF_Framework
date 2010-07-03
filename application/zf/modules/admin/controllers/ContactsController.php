<?php

class Admin_ContactsController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->acl->allow('admin', null);
    }

    public function indexAction() {
        $this->view->message = $this->_helper->flashMessenger->getMessages();
        $model = new App_Model_Contacts();
        $this->view->model = $model->fetchAll("active = 1");
    }

    public function activeAction() {
        $id = (int) $this->getRequest()->getParam('id');
        $content = new App_Model_Contacts();
        $content->statusContact($id);

        return $this->_redirect('/admin/contacts');
    }

    public function viewAction() {
        $id = (int) $this->getRequest()->getParam('id');
        $contacts = new App_Model_Contacts();
        $this->view->contact = $contacts->fetchRow('id = '. $id);

    }

    public function replyAction(){
        $id = (int) $this->getRequest()->getParam('id');
        $contacts = new App_Model_Contacts();
        $this->view->contact = $contacts->fetchRow('id = '. $id);

        $form = new Admin_Form_Contacts_Reply();

        $this->view->form = $form;
    }

    public function editThankyouAction(){

    }
}

