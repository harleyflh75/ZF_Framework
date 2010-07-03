<?php

class Admin_Form_Page_Add extends Zend_Form {

    public function __construct($options = null) {
        parent::__construct();

        $this->setName('Add Page');

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Menu name (Max 30)')
                ->setRequired(true)
                ->addFilter('PregReplace', array('/ /', '_'))
                ->addValidator('stringLength', false, array(3, 30))
                ->addValidator('Db_NoRecordExists', false, array('page', 'name'))
                ->addValidator('NotEmpty', true, array(
                    'messages' => array(
                        'isEmpty' => 'Name is required')))
                ->getValidator('Db_NoRecordExists')->setMessage('Menu item name exists')
        ;

        $parent = new Zend_Form_Element_Select('parent');
        $parent->setLabel('Submenu item of:')
                ->setMultiOptions($options)
                ->setRequired(true)

        ;

        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Title as header')
                ->setRequired(false)
                ->setAttrib('size', '50')
        ;

        $body = new Zend_Form_Element_Textarea('body');
        $body->setLabel('Body')
                ->setRequired(true)
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Submit');

        $menu_id = new Zend_Form_Element_Hidden('menu_id');
        $menu_id->setValue('1');

        $this->addElements(array($name, $parent, $title, $body, $submit, $menu_id));



//        $this->clearDecorators();
//        $this->addDecorator('FormElements')
//         ->addDecorator('HtmlTag', array('tag' => '<ul>'))
//         ->addDecorator('Form');
//
//        $this->setElementDecorators(array(
//            array('ViewHelper'),
//            array('Errors'),
//            array('Description'),
//            array('Label', array('separator'=>' ')),
//            array('HtmlTag', array('tag' => 'li', 'class'=>'element-group')),
//        ));
//
//        // buttons do not need labels
//        $submit->setDecorators(array(
//            array('ViewHelper'),
//            array('Description'),
//            array('HtmlTag', array('tag' => 'li', 'class'=>'submit-group')),
//        ));
    }

}
