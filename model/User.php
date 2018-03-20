<?php
/**
 * Created by PhpStorm.
 * User: adriansmith
 * Date: 3/2/18
 * Time: 12:54 PM
 */

class User
{
    private $_username;
    private $_name;
    private $_email;
    private $_id;
    private $_songs;
    private $_mapping;



    /**
     * User constructor.
     * @param string $username
     * @param string $password
     * @param string $name
     * @param string $email
     */
    function __construct($username = '', $name = '', $email = '', $id = 0, $mapping = 'q2w3er5t6y7ui9o0pzsxdcfv')
    {
        $this->setUsername($username);
        $this->setName($name);
        $this->setEmail($email);
        $this->setID($id);
        $this->setMapping($mapping);
        $this->_songs = array();
    }

    /**
     * Sets username
     * @param $username
     */
    function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * Sets the songs that belong to the user.
     * @param array of Song objects $songs
     */
    function setSongs($songs)
    {
        $this->_songs = $songs;
    }

    /**
     * Sets name
     * @param $name
     */
    function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Sets email
     * @param $email
     */
    function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * Sets the id number of the user
     * @param $id
     */
    function setID($id)
    {
        $this->_id = $id;
    }

    /**
     * @param mixed $mapping
     */
    public function setMapping($mapping)
    {
        $this->_mapping = $mapping;
    }


    /*************** GETTERS ***************/

    /**
     * Gets username
     * @return String username
     */
    function getUsername()
    {
        return $this->_username;
    }

    /**
     * Gets name
     * @return String name
     */
    function getName()
    {
        return $this->_name;
    }

    /**
     * Gets email
     * @return String E-mail
     */
    function getEmail()
    {
        return $this->_email;
    }

    /**
     * Gets id number
     * @return Integer id
     */
    function getID()
    {
        return $this->_id;
    }

    /**
     * Gets the User's songs.
     * @return array of Song ojbects
     */
    function getSongs()
    {
        return $this->_songs;
    }
    /**
     * @return mixed
     */
    public function getMapping()
    {
        return $this->_mapping;
    }

    /**
     * Adds a Song object to user's array of songs.
     * @param Song $song
     */
    function addSong($song)
    {
        $this->_songs[] = $song;
    }
}