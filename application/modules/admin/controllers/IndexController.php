<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        // No output at the moment
         $this->_helper->viewRenderer->setNoRender();
    }

    public function indexAction()
    {
        // action body
    }
}

