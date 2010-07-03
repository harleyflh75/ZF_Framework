<?php

class ErrorController extends Zend_Controller_Action
{
    public function init()
    {
        $this->_helper->acl->allow(null);
    }
    public function errorAction()
    {
        $this->_helper->layout->disableLayout();
        $errors = $this->_getParam('error_handler');
        
        switch ($errors->type) { 
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);

                $this->view->message = preg_replace('/\//', '',$this->view->url(), 1);

                $this->_forward('missing', 'error', NULL, array('title' => $this->view->message));
                break;
            default:
                // application error 
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }
        
        $this->view->exception = $errors->exception;
        $this->view->request   = $errors->request;
    }

    public function missingAction(){
        $this->view->title = $this->getRequest()->getParam('title');

    }
}

