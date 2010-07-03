<?php

class MenuController extends Zend_Controller_Action
{
    /**
     * The controller's init() function is called before 
     * the action. Usually we use it to set up the ACL
     * restrictions for the actions within the controller.
     *
     */
    public function init()
    {
        // allow everyone access to all actions
        $this->_helper->acl->allow('guest', null);
       //$this->_helper->layout->disableLayout();

    }

    public function applicationAction()
    {
        // we don't want to append the menu to the end
        // of the layout content, so:
        //$this->_helper->viewRenderer->setResponseSegment('menu');
        $this->_helper->layout->setLayout('no_layout');
        $this->view->menu = array('x', 'y', 'z');
    }


    public function navAction(){
        

        $menu = $this->getRequest()->getParam('menu');

        $category = new App_Model_MenuCategories();
        $cat = $category->fetchRow(array("menu_name ='".$menu."'",'active = 1'));

        $model = new App_Model_Page();
        $this->view->menus = $model->menuItems($cat->id, false);
        $this->view->sub = $model->menuItems($cat->id,true);

    }
    public function leftAction()
    {

        $this->_helper->layout->disableLayout();
        $main = new App_Model_Menus();

        $this->view->menus = $main->fetchAll(array('menu_id =1','active=1'), 'order');

    }
    public function buttonAction(){
        $this->_helper->layout->disableLayout();
        $this->view->id = Zend_Auth::getInstance()->getIdentity()->id;
        $button = new Menus();
        setcookie('Zend_Auth', 'good',false,'/',false);

        $this->view->menu = $button->fetchAll(array("menutype ='button'",'published = 1'), 'order');
    }
    public function adminAction(){
        $this->_helper->layout->disableLayout();
//        $role = Zend_Auth::getInstance()->getIdentity()->role;
//        $admins = 0;
//        switch ($role){
//            case 'tm':
//                $admins = 1;
//                break;
//            case 'staff':
//                $admins = 2;
//                break;
//            case 'admin':
//                $admins = 3;
//                break;
//            case 'super':
//                $admins = 4;
//                break;
//        }
//        $this->_helper->layout->adminlevel = $admins + 3;
////        $this->layout->adminlevel = $admins + 3;
//        if($admins == 0){
//            return;
//        }
        $button = new App_Model_Menus();

        $this->view->menus = $button->fetchAll(array("menu_id=2",'active=1'), array('order'));
    }
}