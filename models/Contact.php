<?php

include_once 'utilities/MyErrorHandler.php';

/**
 * Set my custom error handler for this script
 */
set_error_handler('MyErrorHandler::errorLogger');

/**
 * Class Contact
 *
 * Contact model object
 *
 */
class Contact
{
    /**
     * @var int - id from SQL database
     */
    public $id;
    /**
     * @var string - name
     */
    public $name;
    /**
     * @var string - surname
     */
    public $surname;
    /**
     * @var string - nickname
     */
    public $nickname;
    /**
     * @var string - email
     */
    public $email;
    /**
     * @var string - mobile phone number
     */
    public $mobileNumber;

    /**
     * Contact constructor.
     * @param string $name
     * @param string $surname
     * @param string $email
     * @param string $mobileNumber
     */
    public function __construct($id, $name, $surname, $nickname, $email, $mobileNumber)
    {
        $this->setName($name);
        $this->setSurname($surname);
        $this->setNickname($nickname);
        $this->setEmail($email);
        $this->setMobileNumber($mobileNumber);
        $this->setId($id);
    }

    /* -------------- Getters and Setters ---------- */
    /**
     * @return int
     */
    public function getId()
    {
        return (int)$this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (string)$this->name;
    }

    /**
     * @param $name - string
     */
    public function setName($name)
    {
        $this->name = (string)$name;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return (string)$this->surname;
    }

    /**
     * @param $surname - string
     */
    public function setSurname($surname)
    {
        $this->surname = (string)$surname;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return (string)$this->nickname;
    }

    /**
     * @param $nickname - string
     */
    public function setNickname($nickname)
    {
        $this->nickname = (string)$nickname;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return (string)$this->email;
    }

    /**
     * @param $email - string
     */
    public function setEmail($email)
    {
        $this->email = (string)$email;
    }

    /**
     * @return string
     */
    public function getMobileNumber()
    {
        return (string)$this->mobileNumber;
    }

    /**
     * @param $mobileNumber - string
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = (string)$mobileNumber;
    }
    /* ---------------------------------------------- */
}