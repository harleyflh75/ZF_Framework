<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Application
 * @package    Controller
 * @copyright  Copyright (c) 2007,2008 Rob Allen
 * @license    http://framework.zend.com/license/new-bsd  New BSD License
 */

/** Zend_Controller_Action_Helper_Abstract */
//require_once 'Zend/Controller/Action/Helper/Abstract.php';


/**
 * ACL integration
 *
 * Places_Controller_Action_Helper_Acl provides ACL support to a 
 * controller.
 *
 * @uses       Zend_Controller_Action_Helper_Abstract
 * @package    Controller
 * @subpackage Controller_Action
 * @copyright  Copyright (c) 2007,2008 Rob Allen
 * @license    http://framework.zend.com/license/new-bsd  New BSD License
 */
class App_Controller_Action_Helper_Acl extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * @var Zend_Controller_Action
     */
    protected $_action;

    /**
     * @var Zend_Auth
     */
    protected $_auth;

    /**
     * @var Zend_Acl
     */
    protected $_acl;

    /**
     * @var string
     */
    protected $_controllerName;

    /**
     * Constructor
     *
     * Optionally set view object and options.
     *
     * @param  Zend_View_Interface $view
     * @param  array $options
     * @return void
     */
    public function __construct(Zend_View_Interface $view = null, array $options = array())
    {
        $this->_auth = Zend_Auth::getInstance();
        $this->_acl = $options['acl'];

        
    }

    /**
     * Hook into action controller initialization
     *
     * @return void
     */
    public function init()
    {
        $this->_action = $this->getActionController();

        // add resource for this controller
        $controller = $this->_action->getRequest()->getControllerName();
        if(!$this->_acl->has($controller)) {
            $this->_acl->add(new Zend_Acl_Resource($controller));
        }
        $this->_controllerName = $controller;
        
    }

    /**
     * Hook into action controller preDispatch() workflow
     *
     * @return void
     */
    public function preDispatch()
    {
        $role = 'guest';
//        die($role);
        if ($this->_auth->hasIdentity()) {
            $user = $this->_auth->getIdentity();
            if(is_object($user)) {
                $role = $this->_auth->getIdentity()->role;
            }
        }

        $request = $this->_action->getRequest();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        $module = $request->getModuleName();

//        $this->view->getLayout()->setLayout($module);
        $this->_controllerName = $controller;

        $resource = $controller;
        $privilege = $action;

        if (!$this->_acl->has($resource)) {
            $resource = null;
        }

        if (!$this->_acl->isAllowed($role, $resource, $privilege)) {
            if (!$this->_auth->hasIdentity()) {
                $noPermsAction = $this->_acl->getNoAuthAction();
            } else {
                $noPermsAction = $this->_acl->getNoAclAction();
            }
            
            $request->setModuleName($noPermsAction['module']);
            $request->setControllerName($noPermsAction['controller']);
            $request->setActionName($noPermsAction['action']);
            $request->setDispatched(false);
           
        }
         
    }

    /**
     * Proxy to the underlying Zend_Acl's allow()
     *
     * We use the controller's name as the resource and the
     * action name(s) as the privilege(s)
     *
     * @param  Zend_Acl_Role_Interface|string|array     $roles
     * @param  string|array                             $actions
     * @uses   Zend_Acl::setRule()
     * @return Places_Controller_Action_Helper_Acl Provides a fluent interface
     */
    public function allow($roles = null, $actions = null)
    {
        $resource = $this->_controllerName;
        
        $this->_acl->allow($roles, $resource, $actions);
        
        return $this;
    }

    /**
     * Proxy to the underlying Zend_Acl's deny()
     *
     * We use the controller's name as the resource and the
     * action name(s) as the privilege(s)
     *
     * @param  Zend_Acl_Role_Interface|string|array     $roles
     * @param  string|array                             $actions
     * @uses   Zend_Acl::setRule()
     * @return Places_Controller_Action_Helper_Acl Provides a fluent interface
     */
    public function deny($roles = null, $actions = null)
    {
        $resource = $this->_controllerName;
        $this->_acl->deny($roles, $resource, $actions);
        return $this;
    }

}
