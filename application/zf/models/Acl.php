<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Acl
 *
 * @author Todd
 */
class App_Model_Acl {

    public function __construct() {

// define Roles
        $this->addRole(new Zend_Acl_Role('guest')); // not authenicated
        $this->addRole(new Zend_Acl_Role('member'), 'guest'); // authenticated as member inherit guest privilages
        $this->addRole(new Zend_Acl_Role('admin'), 'member'); // authenticated as admin inherit member privilages
// define Resources
        $this->add(new Zend_Acl_Resource('error'));
        $this->add(new Zend_Acl_Resource('home'));
        $this->add(new Zend_Acl_Resource('authentication'));
        $this->add(new Zend_Acl_Resource('activity'));

// assign privileges
        $this->allow('guest', array('home', 'error'));
        $this->allow('guest', 'authentication', array('index', 'signin'));

        $this->allow('member', 'authentication', array('index', 'signout'));
        $this->deny('member', 'authentication', 'signin');
        $this->allow('member', 'activity', array('index', 'list')); // member has list privilages for resource activity

        $this->allow('admin', 'activity'); // admin has all privileges for resource activity
    }

}
?>
