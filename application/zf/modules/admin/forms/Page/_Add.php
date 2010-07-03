<?php

class Admin_Form_Page_Add extends Zend_Form {

    public function __construct($data) {
        parent::__construct();

        $this->setMethod('post');
        $this->setName('Add');
//        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('text', 'name', array(
            'label' => 'Menu name (Max 30)',
            'required' => true,
            'validators' => array(array('validator' => 'StringLength',
                    'options' => array(3, 30))
            ),
            'validators' => array(array('validator' => 'Db_NoRecordExists',
                    'options' => array('page', 'name'))
            ),
            'message' => array('Already Used', 'Db_NoRecordExists'),
            'filters' => array(array('filter' => 'PregReplace',
                    'options' => array('/ /', '_'))
            ),
        ));
        $this->addElement('select', 'parent', array(
            'label' => 'Submenu item of:',
            'multiOptions' => $data,
            'required' => true,
        ));

//        $this->addElement('checkbox', 'external', array(
//            'label' => 'External Link?',
////            'required'  =>  true,
//        ));
//        $this->addElement('text', 'link', array(
//            'label' => 'Link',
////            'required'  =>  true,
//            'validators' => array(array('validator' => 'StringLength',
//                    'options' => array(3, 255))
//            ),
//        ));
        $this->addElement('text', 'title', array(
            'label' => 'Title',
//            'required'  =>  true,
            'validators' => array(array('validator' => 'StringLength',
                    'options' => array(0, 100))
            ),
        ));

        $this->addElement('textarea', 'body', array(
            'label' => 'Body',
//            'required'  =>  true,
        ));


        $this->addElement('submit', 'submit', array(
            'label' => 'Submit',
            'ignore' => true,
        ));
    }

}
