<?php
/**
 * Created by PhpStorm.
 * User: adriansmith
 * Date: 3/15/18
 * Time: 7:25 PM
 */

class Song
{
    private $_id;
    private $_name;
    private $_content;

    /**
     * Song constructor.
     * @param $name Name of song
     * @param $content The actual song
     */
    function __construct($id, $name, $content)
    {
        $this->_id = $id;
        $this->_name = $name;
        $this->_content = $content;
    }

    /**
     * Gets song id
     * @return int id
     */
    function getID()
    {
        return $this->_id;
    }

    /**
     * Gets song name.
     * @return String name
     */
    function getName()
    {
        return $this->_name;
    }

    /**
     * Gets content.
     * @return String content
     */
    function getContent()
    {
        return $this->_content;
    }

    /**
     * Sets ID.
     * @param $id
     */
    function setID($id)
    {
        $this->_id = $id;
    }

    /**
     * Sets name.
     * @param $name
     */
    function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Sets song content.
     * @param $content
     */
    function setContent($content)
    {
        $this->_content = $content;
    }
}