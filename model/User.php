<?php
/**
 * Created by PhpStorm.
 * User: adriansmith
 * Date: 2/6/18
 * Time: 2:14 PM
 */

class User
{
    private $_username;
    private $_password;
    private $_name;
    private $_email;
    private $_errors;

    /**
     * User constructor.
     * @param string $username
     * @param string $password
     * @param string $name
     * @param string $email
     */
    function __construct($username = '', $password = '', $name = '', $email = '')
    {
        $this->_errors = null;
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setName($name);
        $this->setEmail($email);
    }

    /**
     * Sets username
     * @param $username
     */
    function setUsername($username)
    {
        if(strlen($username) < 6){
            $this->_errors['username'] = ' * Username must be at least 6 characters.';
        }

        $this->_username = $username;
    }

    /**
     * Sets password
     * @param $password
     */
    function setPassword($password)
    {
        if(ctype_upper($password) || ctype_lower($password)){
            $this->_errors['password'] = ' * Password must contain an uppercase letter, a lowercase letter, and one digit.';
        }
        if(strlen($password) < 6){
            if(isset($this->_errors['password'])){
                $this->_errors['password'] .= ' Password must also be at least 6 characters.';
            }else{
                $this->_errors['password'] = ' * Password must be at least 6 characters.';
            }
        }

        $this->_password = $password;
    }

    /**
     * Sets name
     * @param $name
     */
    function setName($name)
    {
        if(strlen($name) <= 0){
            $this->_errors['name'] = ' * Please enter a name.';
        }else if(preg_match('/\d/', $name)){
            $this->_errors['name'] = ' * Digits are not allowed in your name.';
        }

        $this->_name = $name;
    }

    /**
     * Sets email
     * @param $email
     */
    function setEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->_errors['email'] = ' * Email is not valid.';
        }

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
     * Gets password
     * @return mixed
     */
    function getPassword()
    {
        return $this->_password;
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

    /**
     * Gets array of errors
     * @return associative array of errors
     */
    function getErrors()
    {
        return $this->_errors;
    }

    /**
     * Puts an error in the errors array
     * @param $error The associative name (KEY)
     * @param $desc The value being stored (VALUE)
     */
    function addError($error, $desc)
    {
        $this->_errors["$error"] = $desc;
    }
}