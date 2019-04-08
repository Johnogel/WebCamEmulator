<?php

require_once  'Models/Person.php';

function Login($postData){

    $username = $postData['username'];
    $password = $postData['password'];
    
    $person = new Person($username, $password);
    
    $token = array();
    
    if(!hasExceededLoginMax() && $person->authenticationValid()){
        setAsAuthenticated($person->passwordHash);
    }
    else{
        incrementLoginAttemptsForSession();
        throw new Exception('invalid credentials for '. $person->username);
    }
    
    $result = array(
            'message' => 'Successful'
        );
    echo json_encode($result);
}

function Logout(){
    session_destroy();
    echo json_encode("success");
}

?>
