<?php

class Admin_Model_Topic
{
    protected $_articles;
    protected $_id;
    protected $_title;

    public function __construct($id = null, $title = null, $articles = null)
    {
        if (null !== $id)
        {
            $this->_id = (int)$id;
        }
        if (null !== $title)
        {
            $this->_title = $title;
        }
        if (is_array($articles))
        {
            $this->_articles = $articles;
        }
    }

    public function getArticles()
    {
        return $this->_articles;
    }

    public function setArticles($articles)
    {
        if (is_array($articles))
        {
            $this->_articles = $articles;
        }
        return $this;
    }

    public function getID()
    {
        return $this->_id;
    }

    public function setID($id)
    {
        $this->_id = (int)$id;
        return $this;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function setTitle($title)
    {
        $this->_title = (string)$title;
        return $this;
    }

    public function toArray()
    {
        $result = get_object_vars($this);
        foreach($result as &$value){
           if(is_object($value) && method_exists($value,'toArray')){
              $value = $value->toArray();
           }
        }
        return $result;
    }
}

