<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
    protected function _initViewHelpers()
    {    
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
 
        $view->doctype('HTML5');

        $view->headTitle('zend.site');
        $view->headTitle()->setSeparator(' :: ');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8');
        $view->headLink()->appendStylesheet('/css/slider.css');
        $view->headLink()->appendStylesheet('/css/style.css');
        $view->headScript()->appendFile('/js/jquery-1.11.3.min.js');
        $view->headScript()->appendFile('/js/bootstrap.min.js');
        $view->headScript()->appendFile('/js/startstop-slider.js');
        $view->headScript()->appendFile('/js/script.js');

        $view->headLink()->appendStylesheet('/css/bootstrap.css');

        if(!Zend_Auth::getInstance()->hasIdentity())
        {
            $view->identity = false;
        }else{
            $view->identity = Zend_Auth::getInstance()->getIdentity();
        }
         
    }
    
    protected function _initAutoLoad(){

        $autoLoader = Zend_Loader_Autoloader::getInstance();
 
        $autoLoader->registerNamespace('FirstZend_');
 
        $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
            'basePath'      => APPLICATION_PATH,
            'namespace'     => '',
            'resourceTypes' => array(
                'form' => array(
                    'path'      => 'forms/',
                    'namespace' => 'Form_',
                ),
                'model' => array(
                    'path'      => 'models/',
                    'namespace' => 'Model_'
                ),
                'plugin' => array(
                    'path'      => 'plugins/',
                    'namespace' => 'Plugin_'
                )
            ),
        ));
        return $autoLoader;
    }
    
    protected function _initPlugins()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Plugin_Acl());
    }
}

