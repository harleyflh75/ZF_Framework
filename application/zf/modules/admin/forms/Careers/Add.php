<?php

class Admin_Form_Careers_Add extends Zend_Form
{
    public function __construct()
    {
        parent::__construct();
        
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Job Title')
                ->setRequired(true)
                ->setAttrib('size', '50')
        ;

        $jobid = new Zend_Form_Element_Text('job_id');
        $jobid->setLabel('Job ID')
                ->setRequired(true)
                ->addValidator('stringLength', false, array(0, 30))
        ;

        $email = new Zend_Form_Element_Text('contact');
        $email->setLabel('Contact Email')
                ->setRequired(true)
                ->addValidator('EmailAddress')
        ;
        $intro = new Zend_Form_Element_Textarea('intro');
        $intro->setLabel('Job Introduction')
                ->setRequired(true)
        ;

        $body = new Zend_Form_Element_Textarea('body');
        $body->setLabel('Body')
                ->setRequired(true)
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Submit');

        $this->addElements(array( $title, $jobid, $email, $intro, $body, $submit));
    }
}
