<?php
/* 
 * Created By Todd Archinal
 * Created on Jun 14, 2009
 */

/**
 * Description of LayoutSwitch
 * @version
 * @author Todd Archinal
 */
class App_Controller_Plugin_Navigation extends Zend_Controller_Plugin_Abstract
{
    public function routeShutdown(Zend_Controller_Request_Abstract $request){
        $layout = Zend_Controller_Action_HelperBroker::getStaticHelper('layout');
        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        if ('default' != $module) {
            $menu_id = 2;
            $menu_module = $module;
        }else{
            $menu_id = 1;
            $menu_module = $module;
        }

        $view = $layout->getView();

//        $menus = new App_Model_Menus();
//        $menu = $menus->fetchAll(array('active=1','parent=0','menu_id = '.$menu_id), array('parent','order'));
//        $submenu = $menus->fetchAll(array('active=1','parent > 0','menu_id = '.$menu_id), array('parent','order'));
//        $page = array();
//        $array = array();
//        $i = 0;
//        $j = 0;
//
//        foreach($menu as $level1){
//
//            if( $level1->parent == 0 ){
//                if( $level1->pages == 1){
//                $array = array();
//                    foreach( $submenu as $level2){
//
//                        if($level2->parent == $level1->order){
//                            if($module == $level2->module && $controller == $level2->controller){
//                                $active = 'active';
//                            }else{
//                                $active = '';
//                            }
//
//                            $array[$j] = array('title' => $level2->title,
//                                        'label' => $level2->label,
//                                        'module' => $level2->module,
//                                        'controller' => $level2->controller,
//                                        'action' => $level2->action,
//                                        'uri' => $level2->uri,
//                                        'target' => $level2->target,
//                                        'privilege' => $level1->privilege,
//                                        'class' => $active,
//                                        );
//
//                            $j++;
//                        }
//
//                    }
//                    if($module == $level1->module && $controller == $level1->controller){
//                                $active = 'active';
//
//                            }else{
//                                $active = '';
//                            }
//
//                $page[$i] = array('title' => $level1->title,
//                                'label' => $level1->label,
//                                'module' => $level1->module,
//                                'controller' => $level1->controller,
//                                'action' => $level1->action,
//                                'uri' => $level1->uri,
//                                'target' => $level1->target,
//                                'privilege' => $level1->privilege,
//                                'class' => $active,
//                                'pages' => $array);
//                    $j = 0;
//                }else{
//                if($module == $level1->module && $controller == $level1->controller){
//                                $active = 'active';
//
//                            }else{
//                                $active = '';
//                            }
//
//                $page[$i] = array('title' => $level1->title,
//                                'label' => $level1->label,
//                                'uri' => $level1->uri,
//                                'module' => $level1->module,
//                                'controller' => $level1->controller,
//                                'action' => $level1->action,
//                                'target' => $level1->target,
//                                'privilege' => $level1->privilege,
//                                'class' => $active,
//
//                                );
//                    $j = 0;
//                }
//            }
//
//            $i++;
//
//        }

//        $navigation = new Zend_Navigation($page);
        $navigation = new Zend_Config_Xml(APPLICATION_PATH.'/configs/mainNav.xml', 'nav');
        $view->navigation($navigation);
    }

  
    
}

