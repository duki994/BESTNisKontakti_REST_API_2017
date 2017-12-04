<?php
/**
 * API version 1.1
 * @uses MyDBClass, Queries
 * @author - Dusan K. <duki994@gmail.com
 **/
header("Content-Type: application/json");
require_once(__DIR__ . '/utilities/database/Queries.php');
require_once(__DIR__ . '/utilities/MyErrorHandler.php');
require_once(__DIR__ . '/models/Contact.php');
/**
 * Set my custom error handler for this script
 */
set_error_handler('MyErrorHandler::errorLogger');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new MyDBClass();

    $input = file_get_contents("php://input");
    $loginJsonArr = json_decode($input, true);
    $user = filter_var($loginJsonArr[0]['username'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($loginJsonArr[0]['password'], FILTER_SANITIZE_STRING);


    $loggedUser = Queries::loginUser($user, $password);
    if ($loggedUser !== false) {
        $contactArray = Queries::selectAllContacts();
        //return JSON Array
        echo json_encode($contactArray);
    } else {
        $ret[] = array(
            'login' => false,
        );
        $ret[] = array(
            'msg' => 'User not found',
        );
        //return JSON Array
        echo json_encode($ret);
    }
} else {
    //return JSON Array
    $ret[] = array(
        'login' => false,
    );
    $ret[] = array(
        'msg' => 'Bad request method. Must be POST',
        'requestMethod' => print_r($_SERVER['REQUEST_METHOD'], true),
    );
    echo json_encode($ret);
}




