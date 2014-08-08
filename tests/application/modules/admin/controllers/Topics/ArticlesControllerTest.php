<?php

class Admin_Topics_ArticlesControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testIndexAction()
    {
        $action = 'get';

        $params = array(
            'controller' => 'topics',
            'module' => 'admin'
        );
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams) . '/3/articles';
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller'].'_articles');
        $this->assertAction('index');
        $this->assertResponseCode(200);
    }

    public function testGetAction()
    {
        $action = 'get';

        $params = array(
            'controller' => 'topics',
            'module' => 'admin'
        );
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams) . '/42/articles/9';
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller'].'_articles');
        $this->assertAction($action);
        $this->assertResponseCode(200);
        $this->assertContains(
            '"_text":',
            $this->response->outputBody()
        );
    }

    public function testGetActionFailNoTopic()
    {
        $action = 'get';

        $params = array(
            'controller' => 'topics',
            'module' => 'admin'
        );
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams) . '/2/articles/9';
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller'].'_articles');
        $this->assertAction('notFound');
        $this->assertResponseCode(404);
        $this->assertContains(
            'The topic does not exist.',
            $this->response->outputBody()
        );
    }

    public function testGetActionFailNoArticle()
    {
        $action = 'get';

        $params = array(
            'controller' => 'topics',
            'module' => 'admin'
        );
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams) . '/42/articles/1';
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller'].'_articles');
        $this->assertAction('notFound');
        $this->assertResponseCode(404);
        $this->assertContains(
            'The article does not exist.',
            $this->response->outputBody()
        );
    }

    public function testPostAction()
    {
        $action = 'post';

        $this->request->setMethod($action);
        $params = array(
            'controller' => 'topics',
            'module' => 'admin'
        );
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams) . '/42/articles';
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller'].'_articles');
        $this->assertAction($action);
        $this->assertContains(
            '"_id":',
            $this->response->outputBody()
        );
        $this->assertResponseCode(201);
    }

    public function testPostActionFailed()
    {
        $action = 'post';

        $this->request->setMethod($action);
        $params = array(
            'controller' => 'topics',
            'module' => 'admin'
        );
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams) . '/2/articles';
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller'].'_articles');
        $this->assertAction('notFound');
        $this->assertContains(
            'The topic does not exist.',
            $this->response->outputBody()
        );
        $this->assertResponseCode(404);
    }


    public function testPutAction()
    {
        $action = 'put';

        $this->request->setMethod($action);
        $params = array(
            'controller' => 'topics',
            'module' => 'admin'
        );
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams) . '/42/articles/9';
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller'].'_articles');
        $this->assertAction($action);
        $this->assertContains(
            'Altering articles is not allowed.',
            $this->response->outputBody()
        );

        $this->assertResponseCode(405);
    }
}
