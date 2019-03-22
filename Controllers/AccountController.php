<?php

require_once  'Models/Person.php';



function Login($postData){
    
//    if($username == $usernameMaster && password_verify($password, $passwordHash)){
//        $_SESSION['pass-hash'] = $passwordHash;
//    }
    $username = $postData['username'];
    $password = $postData['password'];
    
    $person = new Person($username, $password);
    
    $token = array();
    
    if(!hasExceededLoginMax() && $person->authenticationValid()){
        setAsAuthenticated($person->passwordHash);
        
        
        //$_COOKIE['']
    }
    else{
        incrementLoginAttemptsForSession();
        throw new Exception('invalid credentials for '. $person->username);
    }
    
    
    $result = array(
            'message' => 'Successful'
        );
    echo json_encode($result);
    
    //$person = 
    
}

function Logout(){
    session_destroy();
    
    
    echo json_encode("success");
}




?>
