<?php
  
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
    
    function sessionRefresh(){
        $timeout_duration = 900;

        session_start([
            'cookie_lifetime' => $timeout_duration,
            'gc_maxlifetime' =>$timeout_duration
        ]);
        
        $time = $_SERVER['REQUEST_TIME'];

        /**
        * for a 30 minute timeout, specified in seconds
        */

        /**
        * Here we look for the user's LAST_ACTIVITY timestamp. If
        * it's set and indicates our $timeout_duration has passed,
        * blow away any previous $_SESSION data and start a new one.
        */
        if (isset($_SESSION['LAST_ACTIVITY']) && 
           ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
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