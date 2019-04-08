<?php
    require_once 'ConfigManager.php';
    
    $rootPath = getenv('APP_ROOT_PATH');
    
    function resolveUrl($path){
        global $rootPath;
        echo $rootPath . '/'. $path;
    }
    
    
    function authenticated(){
        return 
            isset($_SESSION['hash']) 
            && $_SESSION['hash'] != null 
            && isset($_SESSION['authenticated']) 
            && $_SESSION['authenticated'] == true
            && $_SESSION['ip_address'] == $_SERVER['REMOTE_ADDR'];
    }
    
    function setAsAuthenticated($hash){
        $_SESSION['hash'] = $hash;
        $_SESSION['authenticated'] = true;
        $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
        
    }
    
    function getWebCamImageDataUrl(){
        $result = null;
        try{
            $image = 'Images/Webcam/webcamimage.jpg';
            
            $b64image = base64_encode(file_get_contents($image));
            
            $result = 'data: '.mime_content_type($image).';base64,'.$b64image;
            
        } catch (Exception $ex) {
            $result = '';
        }
        
        echo $result;
    }
    
    function incrementLoginAttemptsForSession(){
        $_SESSION['LOGIN_ATTEMPTS'] += 1;
    }
    
    function hasExceededLoginMax(){
        $maxLoginAttempts = getMaxLoginAttempts();
        $attempts = getLoginAttempts();
        return $attempts >= $maxLoginAttempts;
        
        //return ($attempts >= $maxLoginAttempts);
    }
    
    function getMaxLoginAttempts(){
        return ConfigManager::Value("MaxAttempts");
    }
    
    function getLoginAttempts(){
        if(!isset($_SESSION['LOGIN_ATTEMPTS'])){
            $_SESSION['LOGIN_ATTEMPTS'] = 0;
        }
        return (int)$_SESSION['LOGIN_ATTEMPTS'];
    }
    
    function sessionRefresh(){
        $timeout_duration = ConfigManager::Value("LockoutExpirationTimeSeconds");
        
//
//        session_start([
//            'cookie_lifetime' => $timeout_duration,
//            'gc_maxlifetime' =>$timeout_duration
//        ]);
        
        session_start();
        
        
        
        $time = $_SERVER['REQUEST_TIME'];

    
        if (isset($_SESSION['LAST_ACTIVITY']) && 
           ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration && !authenticated())  {
            session_unset();
            session_destroy();
            session_start();
        }

        /**
        * Finally, update LAST_ACTIVITY so that our timeout
        * is based on it and not the user's login time.
        */
        $_SESSION['LAST_ACTIVITY'] = $time;
    }

?>