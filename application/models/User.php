<?php

class Model_User{
    
    protected $_dbTable;
    
    public function __construct($id = null) 
    {
        new Model_DbTable_User();
    }

    public function authorize($email, $password)
    {
        $auth = Zend_Auth::getInstance();
      
        $authAdapter = new Zend_Auth_Adapter_DbTable(
            Zend_Db_Table::getDefaultAdapter(),
            'user',
            'email',
            'password',
            'sha(?) and activated = 1'
        );
       
        $authAdapter->setIdentity($email)->setCredential($password);
        $result = $auth->authenticate($authAdapter);
        
        if($result->isValid())
        {
            $storage = $auth->getStorage();
            $storage->write($authAdapter->getResultRowObject(null, array('password')));
            
            return true;
        }
        return false;
    }
  
}
