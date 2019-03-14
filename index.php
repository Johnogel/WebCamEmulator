<?php
    $rootPath = getenv('APP_ROOT_PATH');
    require_once '.config.php';
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        
        require_once 'Views/MainView.php';
        
    }
    else if($_SERVER['REQUEST_METHOD'] === 'POST'){
        require_once 'Controllers/RouteController.php';
        routeRequest($_SERVER['REQUEST_URI'], $_SERVER['QUERY_STRING']);
        
    }
//    
//    echo $_SERVER['REQUEST_URI'];
//    echo '<br/>';
//    echo $rootPath;

?>