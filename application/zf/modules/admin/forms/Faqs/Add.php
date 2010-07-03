<?php

class Admin_Form_Faqs_Add extends Zend_Form
{
    public function __construct()
    {
        parent::__construct();
        
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

        $this->addElements(array($question, $answer, $submit));
    }
}
