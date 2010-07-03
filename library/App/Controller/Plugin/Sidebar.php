<?php

class App_Controller_Plugin_Sidebar extends Zend_Controller_Plugin_Abstract {

    /**
     * @var Zend_Layout
     */
    protected $_layout;

//    public function __construct(Zend_Layout $layout) {
//        $layout = Zend_Controller_Action_HelperBroker::getStaticHelper('layout');
//        $this->_layout = $layout;
//    }

    public function postDispatch(Zend_Controller_Request_Abstract $request) {
        $layout = Zend_Controller_Action_HelperBroker::getStaticHelper('layout');
        $this->_layout = $layout;
        $html = 'Generate HTML here';
        $this->_layout->sidebar = $html;
    }

}
?>
