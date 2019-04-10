<?php
class ConfigManager {

    private static $settings = null;
    
    private static function GetSettings(){
        if(self::$settings == null){
            self::$settings = json_decode(file_get_contents('config.json'), true);
        }
        return self::$settings;
    }
    
    public static function Value($name){
        $settings = self::GetSettings();
        
        if(isset($settings[$name])){
            return $settings[$name];
        }
        return null;
        
    }
}
