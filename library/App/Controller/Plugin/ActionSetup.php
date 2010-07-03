<?php

/**
 * Front Controller plug in to set up the action stack.
 *
 */
class App_Controller_Plugin_ActionSetup extends Zend_Controller_Plugin_Abstract
{
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
          if ($request->getActionName() === 'application') {
             return;
         }
        $front = Zend_Controller_Front::getInstance();
        if (!$front->hasPlugin('Zend_Controller_Plugin_ActionStack')) {
            $actionStack = new Zend_Controller_Plugin_ActionStack();
            $front->registerPlugin($actionStack, 97);
        } else {
            $actionStack = $front->getPlugin('Zend_Controller_Plugin_ActionStack');
        }

        $menuAction = clone($request);
        $menuAction->setActionName('application')
                ->setControllerName('menu');
//        $actionStack->pushStack($menuAction);
//
//        $advertAction = clone($request);
//        $advertAction->setActionName('advert')
//                ->setControllerName('index');
//        $actionStack->pushStack($advertAction);
    }
}