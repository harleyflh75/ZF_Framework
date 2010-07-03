<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	/**
	 * Initialize the application autoload
	 *
	 * @return Zend_Application_Module_Autoloader
	 */
    protected function _initAppAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'App',
            'basePath'  => dirname(__FILE__),
        ));
        return $autoloader;
    }

    /**
     * Initialize the layout loader
     */
    protected function _initLayoutHelper()
    {
    	$this->bootstrap('frontController');
    	$layout = Zend_Controller_Action_HelperBroker::addHelper(
    		new App_Controller_Action_Helper_LayoutLoader());
    }
    protected function _initAclHelper()
    {
    	$configuration = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        $registry = Zend_Registry::getInstance();
        $registry->configuration = $configuration;
        $acl = new App_Acl();


    	$layout = Zend_Controller_Action_HelperBroker::addHelper(
    		new App_Controller_Action_Helper_Acl(null, array('acl'=>$acl)));
    }
    protected function _initRouter(array $options = null)
{
    // Gets a router object from front controller
    $router = $this->getResource('frontController')->getRouter();

    // Adds some routes
//    $router->addRoute('pages', new Zend_Controller_Router_Route('/content/page/:title', array(
//        'controller' => 'content',
//        'action' => 'page'))
//    );

      $route = new Zend_Controller_Router_Route(
         'page/:title',
          array(
              'controller' => 'page',
             'action'     => 'index',
              'title'   =>  'missing'
          )
      );

      $router->addRoute('page', $route);
    // You can also adds routes using a configuration - ini or XML - file

    // Returns the router to bootstrap resources registry - checks Zend_Application reference to learn more about it
    return $router;
}
}