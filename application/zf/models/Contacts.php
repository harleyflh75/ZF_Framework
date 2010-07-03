<?php
/* 
 * Created By Todd Archinal
 * Created on Jun 15, 2009
 */

/**
 * Description of Contents
 *
 * @author Todd Archinal - Jun 15, 2009
 * 
 */
class App_Model_Contacts extends Zend_Db_Table {

    protected $_name = 'contacts'; // Name of class all lower case
    protected $_referenceMap = array();


    public function getContact($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow(array('id = ' . $id,'active = 1'));
        if (!$row) {
            throw new Exception("Count not find row $id");
        }
//        return $row->toArray();
        return $row;
    }
    public function addContact(array $data)
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
 
    function deleteContact($id)
    {
        $this->delete('id =' . (int)$id);
    }
    function statusContact($id)
    {
        $status = 0;

        $row = $this->fetchRow(array('id = ' . $id,));
        if($row->active == 0){
            $status = 1;
        }
        $this->update(array('active' => $status), 'id = '. (int)$id);
    }
}

