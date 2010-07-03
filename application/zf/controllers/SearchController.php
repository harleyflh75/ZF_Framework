<?php

class SearchController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->acl->allow(null);
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        if ($this->getRequest()->isPost()) {

           if( $_POST['searchterm'] == null || $_POST['searchterm'] == ''){
               $this->view->message = "There was a problem with your search please try again";
           }else{
               $this->view->message = "Here are your search results for ".$_POST['searchterm'];

               //do search of contents
           }
           

        }
        
    }
    public function moduleAction()
    {



    }

}



