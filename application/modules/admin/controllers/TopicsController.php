<?php

class Admin_TopicsController extends Zend_Rest_Controller
{
    protected $_db_model;

    public function init()
    {
        /* Initialize action controller here */
        $this->_db_model = new Admin_Model_TopicMock();
        $this->_helper->layout()->disableLayout();
        $this->getResponse()->setHeader('Content-Type', 'application/json');
    }

    public function indexAction()
    {
        if ($topics = $this->_db_model->fetchAll())
        {
            $this->getResponse()->setHttpResponseCode(200);
            $this->view->topics = $topics;
        }
    }

    public function getAction()
    {
        if ($topic = $this->_db_model->findById($this->_getParam('id')))
        {
            $this->getResponse()->setHttpResponseCode(200);
            $this->view->topic = $topic;
        }
        else
        {
            $this->view->json = array(
                'status' => 404,
                'message' => 'Topic not found.',
            );
            return $this->_forward('notFound');
        }
    }

    public function postAction()
    {
        $requestBody = $this->getRequest()->getRawBody();
        $payload = Zend_Json::decode($requestBody);
        $topic = new Admin_Model_Topic();
        $topic->setTitle($payload['_title'])->setArticles($payload['_articles']);
        $topic = $this->_db_model->persist($topic);
        if (null !== ($id = $topic->getID()))
        {
            $this->view->topic = $topic;
            $topicUri = $this->getBaseUrl() . $id;
            $this->getResponse()->setHttpResponseCode(201);
            $this->getResponse()->setHeader('Location', $topicUri);
        }
    }

    public function putAction()
    {
        $this->getResponse()->setHttpResponseCode(405);
        $this->view->message = array(
            'status' => 405,
            'message' => 'Changing topics is not allowed.'
        );
    }

    public function deleteAction()
    {
        if (null !== $this->_getParam('id'))
        {
            if (null === ($topic = $this->_db_model->findById($this->_getParam('id'))))
            {
                $this->view->json = array(
                    'status' => 404,
                    'message' => 'Topic already gone.',
                );
                return $this->_forward('notFound');
            }
            $this->getResponse()->setHttpResponseCode(200);
            $topicsUri =  $this->getBaseUrl();
            // we could send header or send information in repsonse
            //$this->getResponse()->setHeader('Location', $topicsUri);
            $this->view->message = array(
                'status' => 200,
                'message' => 'Sucessfully removed the topic.'
            );
            return;
        }
        $this->getResponse()->setHttpResponseCode(405);
        $this->view->message = array(
            'status' => 405,
            'message' => 'God-mode not implemented - deleting all topics at once is not allowed.'
        );
    }

    public function headAction()
    {
        // action body
        $this->getResponse()->setHttpResponseCode(204);
    }

    public function notfoundAction()
    {
        $this->getResponse()->setHttpResponseCode(404);
    }

    private function getBaseUrl()
    {
        return
            'http' . (('off' !== $this->getRequest()->getServer('HTTPS', 'off'))?'s':'') . '://' .
            $this->getRequest()->getServer('SERVER_NAME', 'localhost') .
            rtrim ($this->getRequest()->getRequestUri(), '/') . '/';
    }
}
