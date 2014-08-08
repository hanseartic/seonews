<?php

class Admin_TopicsControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
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
        $url = $this->url($urlParams);
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction('index');
        $this->assertResponseCode(200);
        $this->assertContains(
            '"_title":',
            $this->response->outputBody()
        );
    }

    public function testGetAction()
    {
        $action = 'get';

        $params = array(
            'controller' => 'topics',
            'module' => 'admin'
        );
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams) . '/3';
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($action);
        $this->assertResponseCode(200);
        $this->assertContains(
            '"_title":',
            $this->response->outputBody()
        );
    }

    public function testGetActionFail()
    {
        $action = 'get';

        $params = array(
            'controller' => 'topics',
            'module' => 'admin'
        );
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams) . '/2';
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction('notFound');
        $this->assertContains(
            'Topic not found.',
            $this->response->outputBody()
            );
        $this->assertResponseCode(404);
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
        $url = $this->url($urlParams);
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($action);
        $this->assertContains(
            '"_id":',
            $this->response->outputBody()
        );
        $this->assertResponseCode(201);
    }

    public function testPutActionFail()
    {
        $action = 'put';

        $this->request->setMethod($action);
        $params = array(
            'controller' => 'topics',
            'module' => 'admin'
        );
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams) . '/1234';
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($action);
        $this->assertContains(
            'Changing topics is not allowed.',
            $this->response->outputBody()
        );

        $this->assertResponseCode(405);
    }

    public function testDeleteAction()
    {
        $action = 'delete';
        $existingId = 3;

        $this->request->setMethod($action);
        $params = array(
            'controller' => 'topics',
            'module' => 'admin',
        );
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams) . '/' . $existingId;
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($action);
        $this->assertResponseCode(200);
        $this->assertContains(
            'Sucessfully removed the topic.',
            $this->response->outputBody()
        );
    }

    public function testDeleteActionFail()
    {
        $action = 'delete';
        $nonexistingId = 2;

        $this->request->setMethod($action);
        $params = array(
            'controller' => 'topics',
            'module' => 'admin',
        );
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams) . '/' . $nonexistingId;
        $this->dispatch($url);

        $this->assertContains('/' . $nonexistingId, $url);
        $this->dispatch($url);

        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction('notFound');
        $this->assertResponseCode(404);
        $this->assertContains(
            'Topic already gone',
            $this->response->outputBody()
        );
    }

}

