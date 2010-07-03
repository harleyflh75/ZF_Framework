<?php
/* 
 * Created By Todd Archinal
 * Created on Jun 15, 2009
 */

/**
 * Description of Blog Model
 *
 * @author Todd Archinal - Jun 15, 2009
 * 
 */
class App_Model_Posts extends Zend_Db_Table {

    protected $_name = 'posts'; // Name of class all lower case
    protected $_referenceMap = array();

    public function addPost($data)
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
    function updatePost($data,$id)
    {
        $fields = $this->info(Zend_Db_Table_Abstract::COLS);
        foreach ($data as $field => $value) {
            if (!in_array($field, $fields)) {
                unset($data[$field]);
            }
        }
        $this->update($data, 'id = '.$id);
    }
    function deletePost($id)
    {
        $this->delete('id =' . (int)$id);
    }
    function statusPost($id)
    {
        $status = 0;

        $row = $this->fetchRow(array('id = ' . $id,));
        if($row->active == 0){
            $status = 1;
        }
        $this->update(array('active' => $status), 'id = '. (int)$id);
    }

}

