<?php

class App_Acl extends Zend_Acl
{
    private $_noAuth;
    private $_noAcl;
    
    public function __construct()
    {
//        $bootstrap = $this->getInvokeArg('bootstrap');
//        $config = $bootstrap->getOptions();
        $config = Zend_Registry::get('configuration');
        $roles = $config->acl->roles;
        $this->_addRoles($roles);
        $this->_loadRedirectionActions($config->acl);
    }
    
    public function setNoAuthAction($noAuth)
    {
        $this->_noAuth = $noAuth;
    }
    
    public function setNoAclAction($noAcl)
    {
        $this->_noAcl = $noAcl;
    }
    public function getNoAuthAction()
    {
        return $this->_noAuth;
    }
    
    public function getNoAclAction()
    {
        return $this->_noAcl;
    }
    
    protected function _addRoles($roles)
    {
        foreach ($roles as $name=>$parents) {
            if (!$this->hasRole($name)) {
                if (empty($parents)) {
                    $parents = null;
                } else {
                    $parents = explode(',', $parents);
                }
                $this->addRole(new Zend_Acl_Role($name), $parents);
            }
        }
    }

    protected function _loadRedirectionActions($aclConfig)
    {
        $this->_noAuth = array('module' => 'default',
            'controller' => 'auth',
            'action' => 'login');
    
        $this->_noAcl = array('module' => 'default',
            'controller' => 'auth',
            'action' => 'privileges');
    }
}
