<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function __initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML5');
    }

    protected function __initRestRoute()
    {
        $this->bootstrap('frontController');
        $frontController = Zend_Controller_Front::getInstance();
        // we have currently no mod
        $restRoute = new Zend_Rest_Route($frontController, array(), array(
            'admin' => array('topics'))
        );
        $frontController->getRouter()->addRoute('rest', $restRoute);
    }
}

