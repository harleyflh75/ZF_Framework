<?php

class AuthenticationController extends Zend_Controller_Action
{
    protected $_redirectUrl = '/admin/home';

    public function init()
    {
        $this->_helper->acl->allow(null);
        $this->_helper->layout->setLayout('login');
    }

    public function indexAction()
    {
        // If user isn't logged in, show login form
        if (null === Zend_Auth::getInstance()->getIdentity()) {
            $this->_helper->redirector->gotoRouteAndExit(array('action'=>'login'));
        } else {
            $this->_redirect('/admin/home');
        }
    }

    public function loginAction()
    {


        $this->_helper->layout->setLayout('login');
        $form = new App_Form_Auth_LoginForm();
        $form->setAction('/auth/login');
        $this->view->formResponse = '';
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $formData = $this->_getFormData();

                $authAdapter = $this->_getAuthAdapter($formData);
               
                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                if (!$result->isValid()) {
                    $this->view->message = 'Sorry, there was a problem with your submission. Please check the following:';
                } else {

                $data = $authAdapter->getResultRowObject(null,
                            'password');
                
                  $visits = new App_Model_Users();
                  
                  
                  $visits->addVisit($data->id);
                $auth->getStorage()->write($data);

                $this->_redirect($this->_redirectUrl);
                }
            } else {
                // ensure that the Auth adapter is cleared
                $auth = Zend_Auth::getInstance();
                $auth->clearIdentity();

                $this->view->formResponse = 'Sorry, there was a problem with your submission. Please check the following:';
                $form->populate($_POST);
            }
        }
        
        $this->view->form = $form;
    }
    public function identifyAction()
    {
        if ($this->getRequest()->isPost()) {
            // collect the data from the user
            $formData = $this->_getFormData();

            if (empty($formData['username'])
                    || empty($formData['password'])) {
                $this->_flashMessage('Please provide a username and password.');
            } else {
                // do the authentication
                $authAdapter = $this->_getAuthAdapter($formData);
                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                if (!$result->isValid()) {
                    $this->view->message = 'Sorry, there was a problem with your submission. Please check the following:';
                } else {
                    // success: store database row to auth's storage
                    // (Not the password though!)
                    $data = $authAdapter->getResultRowObject(null,
                                'password');
                   
                    $auth->getStorage()->write($data);
                  
                    $this->_redirect($this->_redirectUrl);
                    return;
                }
            }
        }

        $this->_redirect('/auth/login');
    }
    protected function _addvisit($id){
        $data = new Users();

        return;
    }
   public function privilegesAction()
    {
        $this->_forward('login','auth');
    }
    protected function _flashMessage($message) {
        $flashMessenger = $this->_helper->FlashMessenger;
        $flashMessenger->setNamespace('actionErrors');
        $flashMessenger->addMessage($message);
    }

    /**
     * Retrieve the login form data from _POST
     *
     * @return array
     */
    protected function _getFormData()
    {
        $data = array();
        $filterChain = new Zend_Filter;
        $filterChain->addFilter(new Zend_Filter_StripTags);
        $filterChain->addFilter(new Zend_Filter_StringTrim);

        $data['username'] = $filterChain->filter(
            $this->getRequest()->getPost('username'));
        $data['password'] = $filterChain->filter(
            $this->getRequest()->getPost('password'));

        return $data;
    }

    /**
     * Set up the auth adapater for interaction with the database
     *
     * @return Zend_Auth_Adapter_DbTable
     */
    protected function _getAuthAdapter($formData)
    {
//        $dbAdapter = Zend_Registry::get('dbAdapter');
//        $dbAdapter = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini',APPLICATION_ENV );
//        $bootstrap = $this->getInvokeArg('bootstrap');
//        $dbAdapter = $bootstrap->getResource('db');
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('users')
                    ->setIdentityColumn('username')
                    ->setCredentialColumn('password')
                    ->setCredentialTreatment('SHA1(?)');

        // get "salt" for better security
//        $config = Zend_Registry::get('config');
//        $salt = $config->auth->salt;
        $password = $formData['password'];

        $authAdapter->setIdentity($formData['username']);
        $authAdapter->setCredential($password);

        return $authAdapter;
    }
    public function logoutAction()
    {
//        print_r(Zend_Auth::getInstance()->getIdentity());
//        die();
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect('auth/index');
    }

    
}