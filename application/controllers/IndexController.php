<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
       $this->db = Zend_Db_Table::getDefaultAdapter();
    }

    public function indexAction()
    {
        $this->view->headTitle('Главная', 'PREPEND');
        
        $mdlPages = new Model_Admin();       
       
       $this->view->slider = $mdlPages->getSomePage();
    }


}

