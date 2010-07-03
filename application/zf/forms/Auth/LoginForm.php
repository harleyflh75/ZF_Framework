<?php

//include_once 'Zend/Form.php';

class App_Form_Auth_LoginForm extends Zend_Form
{
    public function init()
    {
         $this->setMethod('post');
        $this->setName('Login');

        $this->addElement('text', 'username', array(
                    'label'     =>  'Username',
                    'required'  =>  true,
                    'validators'    =>  array(array('validator' => 'StringLength',
                                                     'options' => array(3,50))
                                         ),

        ));
        $this->addElement('password', 'password', array(
                    'label'     =>  'Password',
                    'required'  =>  true,
                    'validators'    =>  array(array('validator' => 'StringLength',
                                                     'options' => array(4,100))
                                         ),

        ));

        $this->addElement('submit', 'login', array(
                    'label'     =>  'Login',

        ));

    }
}
