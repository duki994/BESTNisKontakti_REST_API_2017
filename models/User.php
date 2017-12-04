<?php

/**
 * Class User
 * * User model
 *
 * @author - Dusan K. <duki994@gmail.com>
 */
class User
{
    /**
     * @var string $username - username
     */
    private $username;
    /**
     * @var string $password - password
     */
    private $password;

    /**
     * User constructor.
     * @param string $username - username passed to constructor
     * @param string $password - password passed to constructor
     */
    public function __construct($username, $password)
    {
        $this->setUsername($username);
        $this->setPassword($password);
    }


    /**
     * @return string
     */
    public function getUsername()
    {
        return (string)$this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = (string)$username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return (string)$this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = (string)$password;
    }
}