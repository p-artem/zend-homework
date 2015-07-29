<?php

class Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    private $_controller = array(
        'controller' => 'error',
        'action' => 'denied'
        );
    
        public function __construct() 
        {
            $acl = new Zend_Acl();
            $acl->addRole(new Zend_Acl_Role('guest'));
            $acl->addRole(new Zend_Acl_Role('admin'));

            $acl->add(new Zend_Acl_Resource('admin'));
            $acl->add(new Zend_Acl_Resource('index'));

            $acl->deny();
            $acl->allow('admin', null);

            $acl->allow('guest', 'admin', array(
                'login'
            ));
            $acl->allow('guest', 'index');

            Zend_Registry::set('acl', $acl);
        }

        public function preDispatch(Zend_Controller_Request_Abstract $request) {
        
        $auth = Zend_Auth::getInstance();
        $acl = Zend_Registry::get('acl');
        
        if($auth->hasIdentity())
        {
            $role = $auth->getIdentity()->role;
        } else {
            $role = 'guest';
        }
        
        if(!$acl->hasRole($role))
        {
            $role = 'guest';
        }
        
        $controller = $request->controller;
        $action = $request->action;
        
        if($controller == 'admin' && $action == 'index')
        {
            $this->_controller['controller'] = 'admin';
            $this->_controller['action'] = 'login';
        }
        
        if(!$acl->has($controller))
        {
            $controller = null;
        }
        
        if(!$acl->isAllowed($role, $controller, $action))
        {
            $request->setControllerName($this->_controller['controller']);
            $request->setActionName($this->_controller['action']);
        }
    }
}