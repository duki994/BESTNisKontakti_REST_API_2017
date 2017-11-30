<?php

include_once 'MyErrorHandler.php';

set_error_handler('MyErrorHandler::errorLogger');

define('NAME', 1);
define('SURNAME', 2);
define('NICKNAME', 3);
define('EMAIL', 4);
define('MOBILENUMBER', 5);

class FilterContacts
{
    /**
     * @param array of Contact objects - a Contact object instance we check
     * @return array - array returning filtered contacts
     */
    public static function filterOutInvalid($contactArray)
    {
        //remove all whitespaces from variables
        $ret = array_map(function ($contact) {
            foreach ($contact as $key => $value) {
                //weird stuff in database. cleanup DB when have time
                $contact[$key] = str_replace(' ', '', $contact[$key]);
                $contact[$key] = str_replace('  ', '', $contact[$key]);
                $contact[$key] = preg_replace('/\s+/', '', $contact[$key]);

                if ($key === 'brMobil') {
                    $contact[$key] = preg_replace("[^0-9]", "", $contact[$key]);
                }

                if ($key === 'nadimak') {
                    $contact[$key] = str_replace('N/A', '', $contact[$key]);
                    $contact[$key] = str_replace('/', '', $contact[$key]);
                }
            }
            return $contact;
        }, $contactArray);

        $ret = array_filter($ret, function ($contact) {
            return self::filterVariable($contact['ime'], NAME) &&
                self::filterVariable($contact['prezime'], SURNAME) &&
                self::filterVariable($contact['nadimak'], NICKNAME) &&
                self::filterVariable($contact['eMail'], EMAIL) &&
                self::filterVariable($contact['brMobil'], MOBILENUMBER);
        });
        return $ret;
    }

    /**
     * @param $var - variable we want to check
     * @param $type - type of var. defined in constants on top of file
     * @return bool - returns if valid or not.
     *
     * check everything. This is PHP and everything can happen
     * I know is_string seems redundant but PHP is magical :D
     */
    private static function filterVariable($var, $type)
    {
        switch ($type) {
            case NAME:
            case SURNAME:
            case NICKNAME:
                return true;
                break;
            case MOBILENUMBER:
                if (strlen($var) > 9) { //more than 9 digits is valid mobile number
                    return true;
                } else {
                    return false;
                }
                break;
            case EMAIL:
                $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
                if (preg_match($pattern, $var) === 1) {
                    return true;
                } else {
                    return false;
                }
                break;
            default:
                return true;
                break;
        }
    }
}