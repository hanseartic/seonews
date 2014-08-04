<?php

class Admin_TopicsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function getAction()
    {
        // action body
        $this->view->message = $this->_getParam('id');
    }

    public function postAction()
    {
        // action body
        $this->getResponse()->setHttpResponseCode(201);
    }

    public function putAction()
    {
        // action body
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function deleteAction()
    {
        // action body
        $this->getResponse()->setHttpResponseCode(204);
    }

}


