<?php

class Form_Login extends Zend_Form
{
    public function __construct() {
        $this->setName('login_form');
        parent::__construct();
    
    
    $username = new Zend_Form_Element_Text('email');
    $username->setLabel('Логин (Email)')
            ->setRequired(true)
            ->addValidator('NotEmpty')
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('EmailAddress');
    
    $password = new Zend_Form_Element_Password('password');
    $password->setLabel('Пароль')
            ->setRequired(true)
            ->addValidator('NotEmpty')
            ->addFilter('StripTags')
            ->addFilter('StringTrim');
    
    $submit = new Zend_Form_Element_Submit('submit');
    $submit->setLabel('Войти');
    
    $this->addElements(array($username, $password, $submit));
            
    }
}
