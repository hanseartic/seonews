<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        // No layout at the moment
        $this->_helper->layout()->disableLayout();
        //$this->_helper->viewRenderer->setNoRender();
    }

    public function indexAction()
    {
        // action body
        $this->view->message = "This page is intentionally left blank.";
    }
}

