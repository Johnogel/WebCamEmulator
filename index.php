<?php
    $rootPath = getenv('APP_ROOT_PATH');
    
    require_once 'Utilities/functions.php';
    
    sessionRefresh();
    
    function resolveUrl($path){
        global $rootPath;
                
        echo $rootPath . '/'. $path;
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