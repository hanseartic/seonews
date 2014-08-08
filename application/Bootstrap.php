<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function __initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML5');
    }

    // setup restful route
    protected function _initRestRoute()
    {
        $this->bootstrap('frontController');
        $frontController = Zend_Controller_Front::getInstance();
        $frontController->getRouter()->addDefaultRoutes();

        // we have currently no mod
        $restRoute = new Zend_Rest_Route($frontController, array(), array(
            'admin' => array('topics'))
        );
        $frontController->getRouter()->addRoute('rest', $restRoute);

        $restRoute = new Zend_Controller_Router_Route_Regex(
            'admin/topics/(.*)/articles/(.*)',
            array(
                'controller' => 'topics_articles',
                'action' => 'index',
                'module' => 'admin'
            ),
            array(1 => 'topic_id', 2 => 'article_id')
        );
        $frontController->getRouter()->addRoute('rest_topics_get', $restRoute);

        $restRoute = new Zend_Controller_Router_Route_Regex(
            'admin/topics/(.*)/articles',
            array(
                'controller' => 'topics_articles',
                'action' => 'index',
                'module' => 'admin'
            ),
            array(1 => 'topic_id')
        );
        $frontController->getRouter()->addRoute('rest_topics', $restRoute);
    }
}

