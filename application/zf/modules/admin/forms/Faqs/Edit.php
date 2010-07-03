<?php
class Admin_Form_Faqs_Edit extends Zend_Form
{
        public function __construct()
    {
        parent::__construct();

        $active = new Zend_Form_Element_Checkbox('active');
        $active->setLabel('Active?')
        ;

        $order = new Zend_Form_Element_Text('order');
        $order->setLabel('order')
                ->setRequired(true)
                ->setAttrib('size', '5')
        ;

        $question = new Zend_Form_Element_Text('question');
        $question->setLabel('Question')
                ->setRequired(true)
                ->setAttrib('size', '200')
        ;

        $answer = new Zend_Form_Element_Textarea('answer');
        $answer->setLabel('Answer')
                ->setRequired(true)
        ;



        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Submit');

        $this->addElements(array($active,$order,$question,$answer, $submit));
    }
}