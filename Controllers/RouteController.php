<?php
    foreach (glob(__DIR__ . "/*.php") as $filename) {
        require_once $filename;
//        echo $filename;
    }
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    function routeArray($pathArray){
        $success = false;
        for($i = 0; $i < count($pathArray); $i++){
            if($pathArray[$i] != '' && $i == (count($pathArray) - 1)){
                if(function_exists($pathArray[$i])){
                    $inputJSON = file_get_contents('php://input');
                    $input = json_decode($inputJSON, TRUE);
                    $func = $pathArray[$i];
                    $func($input);
                    $success = true;
                }
                else{
                    echo 'NOOOOOOO';
                    echo '<br/>';
                    echo $pathArray[i];
                }
            }
            else{
//                echo $i;
            }
        }
        
        if (!$success){
            echo '{"error": "No Function Found"}';
        }
    }
    
    function routeRequest($path, $queryString){
        
        $path = str_replace($rootPath, "", $path);
        //$path 
        
//        echo $path;
        
        $pathArray = explode('/',$path);
        
//        var_dump($pathArray);
        
        if(count($pathArray) > 0){
            routeArray($pathArray);
        }
        else{
//            echo 'ERRROROROR';
        }
        
    }

?>
