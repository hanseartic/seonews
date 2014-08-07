<?php

class Admin_Model_Topics_Article
{
    protected $_author;
    protected $_date;
    protected $_id;
    protected $_text;

    public function __construct($id = null, $author = null, $text = null, $date = null)
    {
        if (null !== $id)
        {
            $this->_id = (int)$id;
        }
        if (null !== $author)
        {
            $this->_author = (string)$author;
        }
        if (null !== $text)
        {
            $this->_text = (string)$text;
        }
        if (null !== $date)
        {
            $this->_date = $date;
        }
    }

    public function getAuthor()
    {
        return $this->_author;
    }

    public function setAuthor($author)
    {
        $this->_author = (string)$author;
        return $this;
    }

    public function getDate()
    {
        return $this->_date;
    }

    public function setDate($date)
    {
        $this->_date = $date;
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

    public function getText()
    {
        return $this->_text;
    }

    public function setText($text)
    {
        $this->text = (string)$text;
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

