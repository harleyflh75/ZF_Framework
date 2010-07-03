<?php

class ContactController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->acl->allow(null);
        $this->view->headTitle('Contact');
    }

    public function indexAction() {
        $model = new App_Model_Page();
        $this->view->model = $model->fetchRow(array("name ='contact'", 'active = 1'));

        $request = $this->getRequest();
        $form = new App_Form_Contact_ContactForm();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $model = new App_Model_Contacts();
                $model->addContact($form->getValues());

                $html = '<table>
                    <tr><td>Name:</td><td>' . $form->getValue('name') . '</td></tr>
                    <tr><td>Email:</td><td>' . $form->getValue('email') . '</td></tr>
                    <tr><td>Comment:</td><td>' . $form->getValue('comment') . '</td></tr>
                    ';
                $txt = 'Name:' . $form->getValue('name') . '
                    Email:' . $form->getValue('email') . '
                    Comment:' . $form->getValue('comment') . '
                    ';
                $dept = 'contact';
                $subject = "New Contact from Website";
                $department = new App_Model_Departments();

//                $department->send($html, $txt, $dept, $subject);

                return $this->_redirect('/contact/thankyou');
            }
        }

        $this->view->form = $form;
    }

    public function thankyouAction() {
        $model = new App_Model_Page();
        $this->view->model = $model->fetchRow(array("name ='contact_thanx'"));
    }

}

