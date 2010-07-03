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
class App_Model_PageTest extends Zend_Db_Table {

    protected $_name = 'page_test'; // Name of class all lower case

    public function getPage($name)
    {
        $row = $this->fetchRow(array("name ='".$name."'",'active = 1'));

        if (!$row) {
            //throw new Exception("Content not set for $title");
            return NULL;
        }
        return $row;
    }

    public function menuItems($id,$sub){
        if($sub){
            $row = $this->fetchAll(array('menu_id = ' . $id, 'active = 1','parent > 0'),'order');
        }
        else{
            $row = $this->fetchAll(array('menu_id = ' . $id, 'active = 1','parent = 0'),'order');
        }
        
        
        return $row;
    }

    public function addPage($data)
    {
        $fields = $this->info(Zend_Db_Table_Abstract::COLS);
        foreach ($data as $field => $value) {
            if (!in_array($field, $fields)) {
                unset($data[$field]);
            }
        }
        
        $data['created'] = date('Y-m-d');

        return $this->insert($data);
    }
    function updatePage($data,$id)
    {
        $fields = $this->info(Zend_Db_Table_Abstract::COLS);
        foreach ($data as $field => $value) {
            if (!in_array($field, $fields)) {
                unset($data[$field]);
            }
        }
        $this->update($data, 'id = '.$id);
    }
    function deletePage($id)
    {
        $this->delete('id =' . (int)$id);
    }
    function statusPage($id)
    {
        $status = 0;

        $row = $this->fetchRow(array('id = ' . $id,));
        if($row->active == 0){
            $status = 1;
        }
        $this->update(array('active' => $status), 'id = '. (int)$id);
    }
    public function getParents($id = 0){
        $parents = $this->select();
        $parents->from('page', array('id', 'name'))
                ->where("active > 0")
                ->where('menu_id > 0')
                ->where('external = 0')
                ->where('parent = 0')
                ->where('id <> '.$id)
                ->order('order');

        $stmt = $parents->query();

        $result = $stmt->fetchAll();
        $parent[0] = 'NOT A SUBMENU';
        foreach ($result as $row) {
            $parent[$row['id']] = ucfirst(str_replace('_',' ',$row['name']));
        }
        return $parent;
    }

    public function getMenuXML(){
        $menu_pages = $this->fetchAll(array('active = 1',"type = 'page'"), 'order');

        $news = new App_Model_News();
        $menu_news = $news->fetchAll(array('active = 1'), 'created DESC',10);

        $posts = new App_Model_Posts();
        $menu_posts = $posts->fetchAll(array('active = 1'), 'created DESC',10);

        Zend_Debug::dump($menu_pages, 'Pages');
    }
}

