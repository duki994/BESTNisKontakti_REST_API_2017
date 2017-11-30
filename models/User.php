<?php
/**
 * Created by PhpStorm.
 * User: duki9
 * Date: 13/11/2017
 * Time: 03:31
 */

class User
{
    private $username;
    private $password;

    /**
     * User constructor.
     */
    public function __construct()
    {
    }


    /**
     * @return mixed
     */
    public function getUsername()
    {
        return (string)$this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = (string)$username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return (string)$this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = (string)$password;
    }
}