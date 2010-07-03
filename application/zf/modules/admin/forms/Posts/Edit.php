<?php
class Admin_Form_Posts_Edit extends Zend_Form
{
    public function __construct()
    {
        parent::__construct();

        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Title')
                ->setRequired(true)
                ->setAttrib('size', '50')
        ;

        $active = new Zend_Form_Element_Checkbox('active');
        $active->setLabel('Active?')
        ;

        $intro = new Zend_Form_Element_Textarea('intro');
        $intro->setLabel('Introduction (300 characters long)')
                ->setRequired(false)
                ->addValidator('stringLength', false, array(0, 300))
        ;

        $body = new Zend_Form_Element_Textarea('body');
        $body->setLabel('Body')
                ->setRequired(true)
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Submit');

        $this->addElements(array( $title,$active, $intro, $body, $submit));
    }
}