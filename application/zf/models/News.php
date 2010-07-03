<?php
/* 
 * Created By Todd Archinal
 * Created on Jun 15, 2009
 */

/**
 * Description of News Model
 *
 * @author Todd Archinal - Jun 15, 2009
 * 
 */
class App_Model_News extends Zend_Db_Table {

    protected $_name = 'news'; // Name of class all lower case
    protected $_referenceMap = array();

    public function addNews($data)
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
    function updateNews($data,$id)
    {
        $fields = $this->info(Zend_Db_Table_Abstract::COLS);
        foreach ($data as $field => $value) {
            if (!in_array($field, $fields)) {
                unset($data[$field]);
            }
        }
        $this->update($data, 'id = '.$id);
    }
    function deleteNews($id)
    {
        $this->delete('id =' . (int)$id);
    }
    function statusNews($id)
    {
        $status = 0;

        $row = $this->fetchRow(array('id = ' . $id,));
        if($row->active == 0){
            $status = 1;
        }
        $this->update(array('active' => $status), 'id = '. (int)$id);
    }

}

