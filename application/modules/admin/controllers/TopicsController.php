<?php

class Admin_TopicsController extends Zend_Rest_Controller
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
        $request_params = $this->getRequest()->getParams();
        //if ($request_params['articles'])
            print_r($request_params);
            print($this->_getParam('id'));
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

    public function headAction()
    {
        // action body
        $this->getResponse()->setHttpResponseCode(204);
    }

}


