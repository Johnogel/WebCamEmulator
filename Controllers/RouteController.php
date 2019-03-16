<?php
    foreach (glob(__DIR__ . "/*.php") as $filename) {
        require_once $filename;
//        echo $filename;
    }

    function callPostFunction($func){
        try{
            $func(json_decode( file_get_contents( 'php://input' ), true ));

        } catch (Exception $ex) {
            header('HTTP/1.0 400 Bad error');
            echo json_encode(
                array(
                    'message' => $ex->getMessage(),
                    'code' => $ex->getCode(),
                )
            );
        }
    }
    
    function routeArray($pathArray){
        $success = false;
        for($i = 0; $i < count($pathArray); $i++){
            if($pathArray[$i] != '' && $i == (count($pathArray) - 1)){
                if(function_exists($pathArray[$i])){
                    $func = $pathArray[$i];
                    callPostFunction($func);
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
        global $rootPath;
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
