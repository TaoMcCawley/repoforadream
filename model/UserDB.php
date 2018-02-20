<?php
/**
 * Created by PhpStorm.
 * User: adriansmith
 * Date: 2/19/18
 * Time: 1:55 PM
 */

/**
 * Class UserDB The class being used to handle all database interactions.
 */
class UserDB
{
    private $_dbh;

    /**
     * UserDB constructor.
     * @param $f3 Needed to get path to pdo config file
     */
    function __construct($f3)
    {
        $path = $f3->get('ROOT')."/../config.php";
        require $path;

        try{
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        }catch(PDOException $e){
            $e->getMessage();
        }
    }

    /**
     * @param $user The user signing up
     * @return bool Whether the insertion was successful or not
     */
    function signup($user)
    {
        if($user->getErrors() == null) {
            $sql = "INSERT INTO USERS (username, password, name, email) VALUES (:username, :password, :name, :email)";

            $stmt = $this->_dbh->prepare($sql);

            $stmt->bindParam(':username', $user->getUsername());
            $stmt->bindParam(':password', sha1($user->getPassword()));
            $stmt->bindParam(':name', $user->getName());
            $stmt->bindParam(':email', $user->getEmail());

            $stmt->execute();

            return true;
        }

        return false;
    }

    /**
     * Checks if a user already exists.
     * @param $user The user being searched for
     * @return bool Whether the user is already in the database
     */
    function exists($user)
    {
        return $this->checkUsername($user) && $this->checkEmail($user);
    }

    /**
     * Checks to see if the table already contains the username
     * @param $user User object
     * @return bool true if the table already contains the username
     */
    function checkUsername($user)
    {
        $sql = "SELECT * FROM USERS WHERE username = :username";
        $stmt = $this->_dbh->prepare($sql);

        $stmt->bindParam(':username', $user->getUsername());

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC) != null;
    }

    /**
     * Checks to see if the table already contains the email
     * @param $user User object
     * @return bool true if the table already contains the email
     */
    function checkEmail($user)
    {
        $sql = "SELECT * FROM USERS WHERE email = :email";
        $stmt = $this->_dbh->prepare($sql);

        $stmt->bindParam(':email', $user->getEmail());

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC) != null;
    }
}