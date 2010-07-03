<?php

/*
 * Created By Todd Archinal
 * Created on Jun 15, 2009
 */

/**
 * Description of Page
 *
 * @author Todd Archinal - Jun 15, 2009
 * 
 */
class App_Model_Page extends Zend_Db_Table {

    protected $_name = 'page';
    // Name of class all lower case
    private $menuArray;

    public function getPage($name) {
        $row = $this->fetchRow(array("name ='" . $name . "'", 'active = 1'));

        if (!$row) {
            //throw new Exception("Content not set for $title");
            return NULL;
        }
        return $row;
    }

    public function menuItems($id, $sub) {
        if ($sub) {
            $row = $this->fetchAll(array('menu_id = ' . $id, 'active = 1', 'parent > 0'), 'order');
        } else {
            $row = $this->fetchAll(array('menu_id = ' . $id, 'active = 1', 'parent = 0'), 'order');
        }


        return $row;
    }

    public function addPage($data) {
        $fields = $this->info(Zend_Db_Table_Abstract::COLS);
        foreach ($data as $field => $value) {
            if (!in_array($field, $fields)) {
                unset($data[$field]);
            }
        }

        $data['created'] = date('Y-m-d');

        return $this->insert($data);
    }

    function updatePage($data, $id) {
        $fields = $this->info(Zend_Db_Table_Abstract::COLS);
        foreach ($data as $field => $value) {
            if (!in_array($field, $fields)) {
                unset($data[$field]);
            }
        }
        $this->update($data, 'id = ' . $id);
    }

    function deletePage($id) {
        $this->delete('id =' . (int) $id);
    }

    function statusPage($id) {
        $status = 0;

        $row = $this->fetchRow(array('id = ' . $id,));
        if ($row->active == 0) {
            $status = 1;
        }
        $this->update(array('active' => $status), 'id = ' . (int) $id);
    }

    public function getParents($id = 0) {
        $parents = $this->select();
        $parents->from('page', array('id', 'name'))
                ->where("active > 0")
                ->where('menu_id > 0')
                ->where('external = 0')
                ->where('parent = 0')
                ->where('id <> ' . $id)
                ->order('order');

        $stmt = $parents->query();

        $result = $stmt->fetchAll();
        $parent[0] = 'NOT A SUBMENU';
        foreach ($result as $row) {
            $parent[$row['id']] = ucfirst(str_replace('_', ' ', $row['name']));
        }
        return $parent;
    }

    public function getMenuXML() {
        $this->_name = 'page_test';
        $menu_pages = $this->fetchAll(array('active = 1', "type = 'page'"), 'created ASC');

        $news = new App_Model_News();
        $menu_news = $news->fetchAll(array('active = 1'), 'created DESC', 10);

        $posts = new App_Model_Posts();
        $menu_posts = $posts->fetchAll(array('active = 1'), 'created DESC', 10);
        $i = 0;

        foreach ($menu_pages as $row) {
            $this->menuRecursion($row);
        }
        return $this->menuArray;
        Zend_Debug::dump($this->menuArray, 'Pages');
    }

    private function menuRecursion($row) {
        if (!$row->pages) {
            if ($row->link != NULL) {
                $this->menuArray[$row->label] = array(
                    'label' => $row->label,
                    'uri' => $row->link,
                    'order' => $row->order,
                    'visible' => $row->visible,
                );
                if ($row->external) {
                    $this->menuArray[$row->label] = array(
                        'label' => $row->label,
                        'uri' => $row->link,
                        'order' => $row->order,
                        'visible' => $row->visible,
                        'target' => '_blank',
                    );
                }
            } elseif ($row->params == NULL) {
                $this->menuArray[$row->label] = array(
                    'label' => $row->label,
                    'route' => $row->route,
                    'module' => $row->module,
                    'controller' => $row->controller,
                    'action' => $row->action,
                    'order' => $row->order,
                    'visible' => $row->visible,
                );
            } else {
                $this->menuArray[$row->label] = array(
                    'label' => $row->label,
                    'route' => $row->route,
                    'module' => $row->module,
                    'controller' => $row->controller,
                    'action' => $row->action,
                    'params' => $this->getParams($row->params),
                    'order' => $row->order,
                    'visible' => $row->visible,
                );
            }
        }
        else{
            $this->menuRecursion($row);
        }
    }

    private function getParams($params) {
        if ($params == '') {
            return array();
        }
        $param = preg_split('/\//', $params);
        for ($i = 0; $i < (sizeof($param)); $i += 2) {
            $allParams[$param[$i]] = $param[($i + 1)];
        }
        return $allParams;
    }

}

