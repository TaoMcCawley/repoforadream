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
        if(!$user->hasErrors() && !$this->exists($user)) {
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
     * @param $username
     * @param $password
     * @return User A user object if login is successful
     */
    function login($username, $password)
    {
        $stmt = $this->_dbh->prepare("SELECT * FROM USERS WHERE username = :username AND password = :password");

        $password = sha1($password);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(empty($result)){
            return null;
        }

        return new User($username, $result['name'], $result['email'], $result['id']);
    }

    /**
     * Checks if a user already exists.
     * @param $user The user being searched for
     * @return bool Whether the user is already in the database
     */
    function exists($user)
    {
        return $this->usernameExists($user) && $this->emailExists($user);
    }

    /**
     * Checks to see if the table already contains the username
     * @param $user User object
     * @return bool true if the table already contains the username
     */
    function usernameExists($user)
    {
        $sql = "SELECT * FROM USERS WHERE username = :username";
        $stmt = $this->_dbh->prepare($sql);

        $name = $user->getUsername();
        $stmt->bindParam(':username', $name);

        $stmt->execute();

        return !empty($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Checks to see if the table already contains the email
     * @param $user User object
     * @return bool true if the table already contains the email
     */
    function emailExists($user)
    {
        $sql = "SELECT * FROM USERS WHERE email = :email";
        $stmt = $this->_dbh->prepare($sql);

        $email = $user->getEmail();
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        return !empty($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Saves a song to the database. Song cannot be an empty song.
     * @param $user User that wants to save a song
     * @param $song The content of the song
     * @return bool Returns false if song is empty
     */
    function saveSong($user, $name, $song)
    {
        if(empty($song) || $user == null){
            return null;
        }

        $sql = "INSERT INTO SONGS (userID, name, content) VALUES (:userID, :name, :content)";

        $stmt = $this->_dbh->prepare($sql);

        $userID = $user->getID();

        $stmt->bindParam(":userID", $userID);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":content", $song);

        $stmt->execute();

        $songID = $this->_dbh->lastInsertId();

        $song = new Song((int) $songID, $name, $song);

        return $song;
    }

    /**
     * Loads all of the User's songs.
     * @param $user User
     * @return array of song objects
     */
    function loadSongs($user)
    {
        $sql = "SELECT * FROM SONGS WHERE userID = :userID";

        $stmt = $this->_dbh->prepare($sql);

        $userID = $user->getID();

        $stmt->bindParam("userID", $userID);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $songs = array();

        foreach($results as $row){
            $songs[] = new Song($row['id'], $row['name'], $row['content']);
        }

        return $songs;
    }
}