<?php

class Admin_Topics_ArticlesController extends Zend_Rest_Controller
{

    protected $_db_model;

    public function init()
    {
        /* Initialize action controller here */
        $this->_db_model = new Admin_Model_Topics_ArticleMock();
        $this->_helper->layout()->disableLayout();
        $this->getResponse()->setHeader('Content-Type', 'application/json');
    }

    public function indexAction()
    {
        switch ($requestMethod = $this->getRequest()->getMethod()) {
            case 'DELETE':
            case 'POST':
            case 'PUT':
                return $this->_forward(strtolower($requestMethod));
                break;
            case 'GET':
            default:
                $_topic_db = new Admin_Model_TopicMock();
                if (null == ($topic = $_topic_db->findById($this->_getParam('topic_id'))))
                {
                    $this->view->json = array(
                        'status' => 404,
                        'message' => 'The topic does not exist.',
                    );
                    return $this->_forward('notFound');
                }
                if (null !== $this->_getParam('article_id'))
                {
                    return $this->_forward('get');
                }
                // this is the actual index-action

                if ($articles = $this->_db_model->fetchAll())
                {
                    $this->view->articles = $articles;
                }
                else
                {
                    $this->view->articles = array();
                }
                $this->getResponse()->setHttpResponseCode(200);
        }
    }

    public function getAction()
    {
        if ($article = $this->_db_model->findById($this->_getParam('article_id')))
        {
            $this->getResponse()->setHttpResponseCode(200);
            $this->view->article = $article;
        }
        else
        {
            $this->view->json = array(
                'status' => 404,
                'message' => 'The article does not exist.',
            );
            return $this->_forward('notFound');
        }
    }

    public function postAction()
    {
        if (null !== $this->_getParam('article_id'))
        {
            return $this->_forward('put');
        }
        $_topic_db = new Admin_Model_TopicMock();
        if (null == ($topic = $_topic_db->findById($this->_getParam('topic_id'))))
        {
            $this->view->json = array(
                'status' => 404,
                'message' => 'The topic does not exist.',
            );
            return $this->_forward('notFound');
        }
        $requestBody = $this->getRequest()->getRawBody();
        $payload = Zend_Json::decode($requestBody);
        $this->getResponse()->setHttpResponseCode(201);
        $article = new Admin_Model_Topics_Article();
        $article->setText($payload['_text'])->setAuthor($payload['_author'])->setDate($payload['_date']);
        $article = $this->_db_model->persist($article);
        if (null !== ($id = $article->getID()))
        {
            $this->view->article = $article;
            $articleUri = $this->getBaseUrl() . $id;
            $this->getResponse()->setHttpResponseCode(201);
            $this->getResponse()->setHeader('Location', $articleUri);
        }
    }

    public function putAction()
    {
        $this->getResponse()->setHttpResponseCode(405);
        $this->view->message = array(
            'status' => 405,
            'message' => 'Altering articles is not allowed.'
        );
    }

    public function deleteAction()
    {
        if ($this->_getParam('article_id'))
        {
            if (null === ($article = $this->_db_model->findById($this->_getParam('article_id'))))
            {
                $this->view->json = array(
                    'status' => 404,
                    'message' => 'Article already gone.',
                );
                return $this->_forward('notFound');
            }
            $this->getResponse()->setHttpResponseCode(200);
            $articlesUri = substr($this->getBaseUrl(), 0, strlen($this->getBaseUrl()) - (strlen($this->_getParam('article_id'))+1));
            // we could send header or send information in repsonse
            //$this->getResponse()->setHeader('Location', $articlesUri);
            $this->view->message = array(
                'status' => 200,
                'message' => 'Sucessfully removed the article.',
                'location' => $articlesUri
            );
            return;
        }
        $this->getResponse()->setHttpResponseCode(405);
        $this->view->message = array(
            'status' => 405,
            'message' => 'Deleting all articles at once is not allowed. Be diligent - or be smart and go straight for the topic.'
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

