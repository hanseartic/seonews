<?php

class Admin_Model_Topics_ArticleMock
{

    // mock the existence of a bunch of articles, here
    private $_articles = array(
        0 => array('id' => 3, 'text' => 'Latest Search Engine Optimization Tweaks prove effective.', 'author' => 'Famous Blogger', 'date' => '1406905629'),
        1 => array('id' => 4, 'text' => 'Remember the lorem ipsum.', 'author' => 'Random Guy', 'date' => '1193832000'),
        1 => array('id' => 9, 'text' => 'Whenever we search for something, we tell a story.', 'author' => 'Tech Specialist', 'date' => '1193832000')
    );

    public function persist(Admin_Model_Topics_Article $article)
    {
        // simulate inserting or updating database here
        if (null === $article->getID())
        {
            // new entry -> 'calculate' new id
            $new_id = 0;
            foreach ($this->_articles as $_article)
            {
                if ($_article['id'] >= $new_id)
                {
                    $new_id = $_article['id']+1;
                }
            }
            $article->setID($new_id);
        }
        return $article;
    }

    public function findById($id)
    {
        $article = array_shift(array_filter(
            $this->_articles,
            function($_article) use ($id)
            {
                return array_key_exists('id', $_article) && $_article['id'] == $id;
            }
        ));
        if (isset($article['id']))
        {
            return new Admin_Model_Topics_Article($article['id'], $article['author'], $article['text'], $article['date']);
        }
    }

    public function fetchAll()
    {
        $frontController = Zend_Controller_Front::getInstance();
        $request_params = $frontController->getRequest()->getParams();
        $result = null;
        if (isset($request_params['topic_id']))
        {
            $result = array();
            $_topic_db_link = new Admin_Model_TopicMock();
            $topic = $_topic_db_link->findById($request_params['topic_id']);
            if (null != $topic)
            {
                $articleIds = $topic->getArticles();
                foreach ($this->_articles as $key => $article) {

                    //var_dump($topic);
                    if (in_array($article['id'], $articleIds))
                    {
                        $result[] = new Admin_Model_Topics_Article($article['id'], $article['author'], $article['text'], $article['date']);
                    }
                }
            }
        }
        return $result;
    }
}

