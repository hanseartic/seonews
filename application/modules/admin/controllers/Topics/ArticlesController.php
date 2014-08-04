<?php

class Admin_Topics_ArticlesController extends Zend_Rest_Controller
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        switch ($this->getRequest()->getMethod()) {
            case 'DELETE':
            case 'POST':
            case 'PUT':
                return $this->_forward($this->getRequest()->getMethod());
                break;
            case 'GET':
            default:
                $request_params = $this->getRequest()->getParams();
                if (isset($request_params['article_id']))
                {
                    return $this->_forward('GET');
                }
                // action body
                $this->getResponse()->setHttpResponseCode(200);
        }
    }

    public function getAction()
    {
        // action body
         $this->getResponse()->setHttpResponseCode(200);
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
