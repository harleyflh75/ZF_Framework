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
 
class App_Model_MenuCategories extends Zend_Db_Table {

    protected $_name = 'menu_categories';

    public function getCategories($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow(array('id = ' . $id,'active = 1'));
        if (!$row) {
            throw new Exception("Count not find row $id");
        }
        return $row;
    }

    public function getMenu($name)
    {

        $row = $this->fetchRow(array('id = ' . $id,'active = 1'));
        if (!$row) {
            throw new Exception("Count not find row $id");
        }
        return $row;
    }
    public function addCategories($data)
    {
//        $data = array(
//            'artist' => $artist,
//            'title' => $title,
//        );
        $this->insert($data);
    }

    function updateCategories($id, $data)
    {
//        $data = array(
//            'artist' => $artist,
//            'title' => $title,
//        );
        $this->update($data, 'id = '. (int)$id);

    }

    function deleteCategories($id)
    {
        $this->delete('id =' . (int)$id);
    }
    function statusCategories($id)
    {
        $status = 0;

        $row = $this->fetchRow(array('id = ' . $id,));
        if($row->active == 0){
            $status = 1;
        }
        $this->update(array('active' => $status), 'id = '. (int)$id);
    }
}

