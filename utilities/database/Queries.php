<?php
include_once 'utilities/MyErrorHandler.php';
include_once 'utilities/database/MyDBClass.php';
include_once 'utilities/FilterContacts.php';
include_once 'models/User.php';

define('BINDINGS_EMAIL', ':email');
define('BINDINGS_PASSWORD', ':pass');

define('BINDINGS_REQUIRED', true);
define('BINDINGS_NOT_REQUIRED', false);
/**
 * Set my custom error handler for this script
 */
set_error_handler('MyErrorHandler::errorLogger');

class Queries
{

    /**
     * @var string - query to select user (for login)
     */
    private static $selectUser = "SELECT * FROM hr_clan WHERE eMail=" . BINDINGS_EMAIL .
    " AND lozinka=" . BINDINGS_PASSWORD . " AND status != 'neaktivan'";
    /**
     * @var string - select all member from Portal (read Contacts as I read only data that is logically
     *               connected to creating contacts ;))
     */
    private static $selectAllContacts = "SELECT ime, prezime, nadimak, eMail, brMobil, id FROM hr_clan";

    /**
     * @var MyDBClass - instance of MyDBClass used for database operation
     */
    private static $db;

    /**
     * @param $user - username (email in this case)
     * @param $password - password
     * @return mixed - returns found user as User object. If not found returns <b>FALSE</b>
     **/
    public static function loginUser($user, $password)
    {
        self::$db == null && self::$db = new MyDBClass();
        self::$db->prepareQuery(self::$selectUser);
        self::$db->bind(BINDINGS_EMAIL, $user);
        self::$db->bind(BINDINGS_PASSWORD, $password);
        self::$db->execute();
        $result = self::$db->resultAssoc(); /* stavice array u array (bice $user[0])* jer ocekuje vise rezultata */
        if ($result[0]) {
            $user = new User();
            $user->setUsername($result[0]['eMail']);
            $user->setPassword($result[0]['lozinka']);
            return $user;
        }
        return false;
    }

    /**
     * @return array - returns array of valid filtered Contacts (read PDO::fetchAssoc docs)
     */
    public static function selectAllContacts()
    {
        self::$db == null && self::$db = new MyDBClass();
        self::$db->prepareQuery(self::$selectAllContacts);
        self::$db->execute();
        $filteredContacts = FilterContacts::filterOutInvalid(self::$db->resultAssoc());
        $contactModelArray = array();
        foreach ($filteredContacts as &$contact) {
            $contactModelArray[] = new Contact($contact['id'], $contact['ime'], $contact['prezime'], $contact['nadimak'], $contact['eMail'], $contact['brMobil']);
        }
        return $contactModelArray;
    }
}