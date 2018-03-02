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

    /**
     * User constructor.
     * @param string $username
     * @param string $password
     * @param string $name
     * @param string $email
     */
    function __construct($username = '', $name = '', $email = '')
    {
        $this->setUsername($username);
        $this->setName($name);
        $this->setEmail($email);
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


    /*************** GETTERS ***************/

    /**
     * Gets username
     * @return mixed
     */
    function getUsername()
    {
        return $this->_username;
    }

    /**
     * Gets name
     * @return mixed
     */
    function getName()
    {
        return $this->_name;
    }

    /**
     * Gets email
     * @return mixed
     */
    function getEmail()
    {
        return $this->_email;
    }
}