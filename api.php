<?php
header("Content-Type: application/json");
include_once 'utilities/database/Queries.php';
include_once 'utilities/MyErrorHandler.php';
include_once 'models/Contact.php';
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
            'username' => $user,
            'password' => $password,
            'input' => file_get_contents("php://input"),
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
        'msg' => 'User not found',
        'requestMethod' => print_r($_SERVER['REQUEST_METHOD'], true),
    );
    echo json_encode($ret);
}




