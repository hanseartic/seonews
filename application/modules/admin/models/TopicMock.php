<?php

class Admin_Model_TopicMock
{

    // mock the existence of two topics, here
    private $_topics = array(
        0 => array('id' => 3, 'title' => 'Latest Search Engine Optimization Tweaks', 'articles' => array()),
        1 => array('id' => 42, 'title' => 'Gossip', 'articles' => array(2, 3, 9, 10))
    );

    public function persist(Admin_Model_Topic $topic)
    {
        // simulate inserting or updating database here
        if (null === $topic->getID())
        {
            // new entry -> 'calculate' new id
            $new_id = 0;
            foreach ($this->_topics as $_topic)
            {
                if ($_topic['id'] >= $new_id)
                {
                    $new_id = $_topic['id']+1;
                }
            }
            $topic->setID($new_id);
        }
        return $topic;
    }

    public function findById($id)
    {
        $topic = array_shift(array_filter(
            $this->_topics,
            function($_topic) use ($id)
            {
                return array_key_exists('id', $_topic) && $_topic['id'] == $id;
            }
        ));
        if (isset($topic['id']))
        {
            return new Admin_Model_Topic($topic['id'], $topic['title'], $topic['articles']);
        }
    }

    public function fetchAll()
    {
        $result = array();
        foreach ($this->_topics as $key => $topic) {
            $result[] = new Admin_Model_Topic($topic['id'], $topic['title'], $topic['articles']);
        }
        return $result;
    }
}
