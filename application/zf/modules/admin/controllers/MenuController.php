<?php

class Admin_MenuController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->acl->allow('admin',null);
    }

    public function indexAction()
    {
        $this->view->message = $this->_helper->flashMessenger->getMessages();
        $model = new App_Model_MenuCategories();
        $cat = $model->fetchAll();
        $request = $this->getRequest();
        $form = new Admin_Form_Menu_Categories($cat);

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {

                $model = new App_Model_Departments();
                $model->addDepartment($form->getValues()) ;

                return $this->_redirect('/admin/menu/category/cat/'.$form->getValue('category'));
            }
        }
        $this->view->form = $form;
    }
    public function categoryAction()
    {
        
        $id = (int) $this->getRequest()->getParam('cat');
        $this->view->message = $this->_helper->flashMessenger->getMessages();
        $model = new App_Model_Menus();
        $this->view->model = $model->fetchAll('menu_id = '.$id,'order');
        $this->view->cat = $id;
    }
    public function addAction()
    {
        $id = (int) $this->getRequest()->getParam('cat');
        $request = $this->getRequest();
        $form    = new Admin_Form_Menu_Add($id);

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {

                $model = new App_Model_Menus();
                $model->addMenus($form->getValues()) ;
                $this->_helper->flashMessenger->addMessage('Added') ;
                return $this->_redirect('/admin/menu');
            }
        }

        $this->view->form = $form;

    }
    public function activeAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $content = new App_Model_Menus();
        $content->statusDepartment($id);

        return $this->_redirect('/admin/menu');
    }
    public function editAction()
    {
        $request = $this->getRequest();
        $form    = new Admin_Form_Menu_Edit();
        $id = (int) $this->getRequest()->getParam('id');
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {

                $model = new App_Model_Menus();
                $model->updateMenus($form->getValues(),$id);
                $this->_helper->flashMessenger->addMessage('Edited') ;
                return $this->_redirect('/admin/menu');
            }
        }
        if($id > 0) {
              $news = new App_Model_Menus();
              $ad = $news->fetchRow('id='.$id);
              $form->populate($ad->toArray());
          }
        $this->view->form = $form;
    }
}

