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
 
class App_Model_Users extends Zend_Db_Table {

    protected $_name = 'users';

    public function addVisit($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow(array('id = ' . $id));
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        $visits = $row->visits +1;
        $this->update(array('visits'=>$visits), 'id ='.$id);
        return $visits;
    }
    public function addUser($data)
    {
        $fields = $this->info(Zend_Db_Table_Abstract::COLS);
        foreach ($data as $field => $value) {
            if (!in_array($field, $fields)) {
                unset($data[$field]);
            }
        }
        $data['password'] = sha1($data['password']);
        $data['created'] = date('Y-m-d');

        return $this->insert($data);
    }
    function updateUser($data,$id)
    {
        $fields = $this->info(Zend_Db_Table_Abstract::COLS);
        foreach ($data as $field => $value) {
            if (!in_array($field, $fields)) {
                unset($data[$field]);
            }
        }
        $data['password'] = sha1($data['password']);
        $this->update($data, 'id = '.$id);
    }
    function deleteUser($id)
    {
        $this->delete('id =' . (int)$id);
    }
    function statusUser($id)
    {
        $status = 0;

        $row = $this->fetchRow(array('id = ' . $id,));
        if($row->active == 0){
            $status = 1;
        }
        $this->update(array('active' => $status), 'id = '. (int)$id);
    }

}

