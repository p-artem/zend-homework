<?php

class Form_Page extends Zend_Form
{
    public function __construct() 
    {   
        $this->setName('form_addPage');
        parent::__construct();
        
        $id = new Zend_Form_Element_Text('id');
        $id->setAttrib('style', 'display:none');
        
        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Image:')
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->addValidator('Size', false, 1024000)
                ->addValidator('Extension', false, 'jpg,png,gif'); 
        
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Title:')
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->addFilter('StripTags')
                ->addFilter('StringTrim');
                
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Сохранить')
                ->setAttribs(array(
                    'label' => 'Добавить', 
                    'class' => 'btn btn-primary', 
                ));
        
        
        $this->addElements(array($id, $image, $title, $submit));
    }
}
