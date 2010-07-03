<?php

//include_once 'Zend/Form.php';

class Admin_Form_Users_Edit extends Zend_Form
{
    public function __construct()
    {
        parent::__construct();

        $this->setMethod('post');
        $this->setName('Add');
//        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('checkbox', 'active', array(
            'label'     =>  'Status - Active/Disabled',
          
        ));
        $this->addElement('text', 'username', array(
            'label'     =>  'Username',
            'validators'    =>  array(array('validator' => 'StringLength',
                                                     'options' => array(3,100))
                                         ),
        ));

        $this->addElement('password', 'password', array(
            'label'     =>  'Password',
            'required'  =>  true,
            'validators'    =>  array(array('validator' => 'StringLength',
                                                     'options' => array(3,100))
                                         ),

        ));

        $this->addElement('text', 'role', array(
            'label'     =>  'Role',
            'required'  =>  true,
//            'validators'    =>  array(array('validator' => 'EmailAddress')
//                                         ),
        ));


        $this->addElement('submit', 'submit', array(
            'label'     =>  'Submit',
            'ignore' => true,
        ));
        

    }
}
