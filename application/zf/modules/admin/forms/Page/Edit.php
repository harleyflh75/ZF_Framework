<?php

class Admin_Form_Page_Edit extends Zend_Form {

    public function __construct($options = null) {
        parent::__construct();

        $this->setName('Edit Page');

        $active = new Zend_Form_Element_Checkbox('active');
        $active->setLabel('Active?')
        ;

        $name = new Zend_Form_Element_Text('temp_name');
        $name->setLabel('Menu name (cannot change)')
                ->setAttrib('disabled', true)
                ->setAttrib('readonly', true);

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

        $order = new Zend_Form_Element_Text('order');
        $order->setLabel('Order in menu')
                ->setRequired(true)
                ->setValue('999')

        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Submit');

        $menu_id = new Zend_Form_Element_Hidden('menu_id');
        $menu_id->setValue('1');

        $menu_id = new Zend_Form_Element_Hidden('name');

        $this->addElements(array($active, $name, $parent, $title, $body, $submit, $menu_id, $order, $name));
    }

    public function populate(array $values) {
        $values['temp_name'] = str_replace('_', ' ', $values['name']);
        return parent::populate($values);
    }

}
