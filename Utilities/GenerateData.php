<?php


    $clear = false;
    if(isset($argc) && isset($argv) && $argv > 2){
        if($argv > 3){
//            var_dump($argv);
            $clear = ($argv[3] == 'clear');
            
            
        }
        $username = $argv[1];
        $password = $argv[2];
    }
    
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    $dataPath = dirname(__FILE__).'/data.json';
    
    $person = array(
        'username' => $username,
        'passwordHash' => $hash
    );
    
    $fileContents = array();

    
    
    if(file_exists($dataPath)){
       if(!$clear){
            $result = json_decode(file_get_contents($dataPath), true);
            if(is_array($result)){
                $fileContents = $result;
            }    
        } 
    }
    
    array_push($fileContents, $person);
    
    file_put_contents($dataPath, json_encode($fileContents));
    
    
    
    
    
    
    
    
    
    

    

?>