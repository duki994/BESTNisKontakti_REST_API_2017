<?php
require_once(__DIR__ . '/../utilities/MyErrorHandler.php');

/**
 * Set my custom error handler for this script
 */
set_error_handler('MyErrorHandler::errorLogger');

/**
 * Class Contact
 * * Contact model object
 *
 * @author - Dusan K. <duki994@gmail.com>
 * @uses JsonSerializable interface to serialize object vars (json_encode can't serialize private members)
 */
class Contact implements JsonSerializable
{
    /**
     * @var int - id from SQL database
     */
    private $id;
    /**
     * @var string - name
     */
    private $name;
    /**
     * @var string - surname
     */
    private $surname;
    /**
     * @var string - nickname
     */
    private $nickname;
    /**
     * @var string - email
     */
    private $email;
    /**
     * @var string - mobile phone number
     */
    private $mobileNumber;

    /**
     * @var string - Path to profile/avatar image of contact
     * Use with Android lazy load library (like Picasso)
     * Base 64 enoding adds too much data (~25MB JSOn for 300 contacts).
     * And constant server polling for JSON is also too much
     */
    private $imgPath;


    /**
     * Contact constructor.
     * @param $id - Contact id from database
     * @param $name - Contact name from database
     * @param $surname - Contact surname from database
     * @param $nickname - Contact nickname from database
     * @param $email - Contact email from database
     * @param $mobileNumber - Contact mobile number from database
     * @param $imgPath - - Contact base64 encoded profile image
     */
    public function __construct($id, $name, $surname, $nickname, $email, $mobileNumber, $imgPath = '')
    {
        $this->setName($name);
        $this->setSurname($surname);
        $this->setNickname($nickname);
        $this->setEmail($email);
        $this->setMobileNumber($mobileNumber);
        $this->setId($id);
        $this->setImgPath($imgPath);
    }

    /* -------------- Getters and Setters ---------- */

    /**
     * @return string
     */
    public function getImgPath()
    {
        return (string)$this->imgPath;
    }

    /**
     * @param string $imgPath
     */
    public function setImgPath($imgPath)
    {
        $this->imgPath = (string)$imgPath;
    }

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

    /**
     * JsonSerializable interface function override
     * Get non statical object properties (private, protected and public)
     * as associative array
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return (array)get_object_vars($this);
    }
}