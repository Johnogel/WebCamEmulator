<?php
    $rootPath = getenv('APP_ROOT_PATH');
    require_once '.config.php';
    session_start();
    
    function resolveUrl($path){
        global $rootPath;
                
        echo $rootPath . '/'. $path;
    }
    
    function authenticated(){
        return isset($_SESSION['hash']) && $_SESSION['hash'] != null && isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == true;
    }
    
    function setAsAuthenticated($hash){
        $_SESSION['hash'] = $hash;
        $_SESSION['authenticated'] = true;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        
        require_once 'Views/MainView.php';
        
    }
    else if($_SERVER['REQUEST_METHOD'] === 'POST'){
        require_once 'Controllers/RouteController.php';
        routeRequest($_SERVER['REQUEST_URI'], $_SERVER['QUERY_STRING']);
        
    }
    //echo phpinfo();
?>