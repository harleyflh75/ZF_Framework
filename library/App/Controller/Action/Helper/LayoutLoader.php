<?php

class App_Controller_Action_Helper_LayoutLoader extends Zend_Controller_Action_Helper_Abstract
{
	
	public function preDispatch() 
	{
		$bootstrap = $this->getActionController()->getInvokeArg('bootstrap');
		$config = $bootstrap->getOptions();
		$module = $this->getRequest()->getModuleName();
		if (isset($config[$module]['resources']['layout']['layout'])) {
			$layoutScript = $config[$module]['resources']['layout']['layout'];
			$this->getActionController()
				 ->getHelper('layout')
				 ->setLayout($layoutScript);
		}
                if(isset($config[$module]['site'])){
                    $headtitle = $config[$module]['site']['headtitle'];
                    $keywords = $config[$module]['site']['keywords'];
                    $description = $config[$module]['site']['description'];
                    $layout = $module.'.css';
                    $favicon = $module.'/favicon.ico';

                }else{
                    $headtitle = $config['site']['headtitle'];
                    $keywords = $config['site']['keywords'];
                    $description = $config['site']['description'];
                    $layout = 'default.css';
                    $favicon = 'favicon.ico';
                }

                $view = new Zend_View();

                $view->doctype('XHTML1_STRICT');
                $view->headTitle($headtitle);
                $view->headTitle()->setSeparator(' | ');
                $view->headLink()->prependStylesheet('/css/'.$layout)
                                 ->headLink(array('rel' => 'favicon',
                                          'href' => '/images/'.$favicon),
                                          'PREPEND')
                                 ->prependStylesheet('/css/reset.css')
                                 ->appendStylesheet('/css/menu.css'
                                             );
                $view->env = APPLICATION_ENV;
                $view->headMeta()->appendName('keyword',$keywords)
                                 ->appendName('description',$description)
                                 ->appendHttpEquiv('Content-Type','text/html; charset=UTF-8')
                                 ->appendHttpEquiv('Content-Language', 'en-US');


	}
	
}