<?php
/* 
 * Created By Todd Archinal
 * Created on Jun 15, 2009
 */

/**
 * Description of Menus
 *
 * @author Todd Archinal - Jun 15, 2009
 */
 
class App_Model_Menus extends Zend_Db_Table {

    protected $_name = 'menus';

    public function getMenus($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow(array('id = ' . $id,'active = 1'));
        if (!$row) {
            throw new Exception("Count not find row $id");
        }
        return $row;
    }

    public function addMenus($data)
    {
        $fields = $this->info(Zend_Db_Table_Abstract::COLS);
        foreach ($data as $field => $value) {
            if (!in_array($field, $fields)) {
                unset($data[$field]);
            }
        }
        if($data['visible'] == 1){
            $data['visible'] = 'true';
        }else{
            $data['visible'] = 'false';
        }
        if($data['uri'] != null || $data['uri'] != ''){
            $data['module'] = null;
            $data['controller'] = null;
            $data['action'] = null;
        }
//        print_r($data);
//        die();
        $data['created'] = date('Y-m-d');

        $this->insert($data);
    }

    function updateMenus( $data,$id)
    {
        $fields = $this->info(Zend_Db_Table_Abstract::COLS);
        foreach ($data as $field => $value) {
            if (!in_array($field, $fields)) {
                unset($data[$field]);
            }
        }
        
        if($data['uri'] != null || $data['uri'] != ''){
            $data['module'] = null;
            $data['controller'] = null;
            $data['action'] = null;
        }
        $this->update($data, 'id = '. (int)$id);

    }

    function deleteMenus($id)
    {
        $this->delete('id =' . (int)$id);
    }
    function statusMenus($id)
    {
        $status = 0;

        $row = $this->fetchRow(array('id = ' . $id,));
        if($row->active == 0){
            $status = 1;
        }
        $this->update(array('active' => $status), 'id = '. (int)$id);
    }
    public function checkMenu($title){
        $row =  $this->fetchRow(array("label = '".$title."'"));
        if(isset($row)){
            return 0;
        }
        return 1;
    }
    public function addPage($title){
        $data = array();
        $data['label'] = $title;
        $data['title'] = ucfirst($title);
        $data['module'] = null;
        $data['controller'] = null;
        $data['action'] = null;
        $data['uri'] = '/content/page/'.$title;
        $data['menu_id'] = 1;
        $data['created'] = date('Y-m-d');

        $this->insert($data);
    }
}

