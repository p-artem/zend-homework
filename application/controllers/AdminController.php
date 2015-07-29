<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        $this->db = Zend_Db_Table::getDefaultAdapter();
    }
    
    public function indexAction()
    {  
        $this->view->title = "Журнал страниц";
        $this->view->headTitle($this->view->title, 'PREPEND');

        $mdlPages = new Model_Admin();
        $this->view->page = $mdlPages->getAllPage(); 
    }
    
    public function addAction()
    {
       $this->view->title = "Добавить страницу";
       $this->view->headTitle($this->view->title, 'PREPEND');
       
       $frmPage = new Form_Page();
       
       if ($this->_request->isPost()){
            if ($frmPage->isValid($this->_request->getParams()))
            {                 
                $adapter = new Zend_File_Transfer_Adapter_Http();               
                $adapter->setDestination(SITE_PATH.'img'.DS.'upload');       
                $adapter->receive();
                
                $fileName = $adapter->getFileName('image', false);
                $paramStr = $frmPage->getValues(); 
                $paramStr['image'] = $fileName;
                               
                $mdlPages = new Model_Admin();
                $mdlPages->fill($paramStr);
                $mdlPages->save();
                $this->_helper->redirector('index');
            }
        }
       $this->view->form = $frmPage;
    }
    
    public function deleteAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        
         if ($this->_request->isPost()){
             $paramId = $this->getParam('id');
                          
             $mdlPages = new Model_Admin($paramId);
             $deletePage = $mdlPages->deletePage();
             $json = Zend_Json::encode($deletePage);
              echo Zend_Json::prettyPrint($json);
              die();
         }
    }
    
    public function editAction()
    {
       $this->view->title = "Редактирование страницы";
       $this->view->headTitle($this->view->title, 'PREPEND');
       
       $id = $this->getRequest()->getParam('id');
       
       $mdlPages = new Model_Admin($id);
       $parametr = $mdlPages->getPageItem($id);
       
       $formEdit = new Form_PageEdit();
       $formEdit->addDecorator('HtmlTag', array (
        'tag'   => 'img',
        'class' => 'myElement',
        'id' => $parametr['image'],
        'alt' => 'no-image',
        'src' => DS.'img'.DS.'upload'.DS.$parametr['image']));        
        
        if ($this->_request->isPost()){
            if ($formEdit->isValid($this->_request->getParams())){
                
            $params = $formEdit->getValues();
            
            $flag = $params['delete'];
            if($flag) 
            {
                $params['image'] = '';
            } 
            
            $mdlPages->fill($params);
            $mdlPages->save();
            $this->_helper->redirector('index');
            
            }
        } 
      $formEdit->populate($mdlPages->populateForm()); 
       $this->view->form = $formEdit;
    }
    
    public function viewAction()
    {
       $this->view->title = "Просмотр страницы";
       $this->view->headTitle($this->view->title, 'PREPEND');
    }
    
     public function loginAction()
     {
          
        $formLogin = new Form_Login();
          if ($this->_request->isPost()){
            if ($formLogin->isValid($this->_request->getParams()))
            {   
                $user  = new Model_User();
                if($user->authorize($formLogin->getValue('email'), $formLogin->getValue('password')))
                {
                    $this->_helper->redirector('index');
                }else{
                    $this->view->error = 'Неверные данные авторизации';
                }  
            }
        }
         
         $this->view->form = $formLogin;
     }
     
     public function logoutAction()
     {
         $auth = Zend_Auth::getInstance();
         $auth->clearIdentity();
         $this->_helper->redirector('login');
     }

}
