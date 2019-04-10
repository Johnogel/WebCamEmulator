<?php
    class Database{
        
        
        public function getPerson($username){
            $fileArray = array() ;

            $fileArray = json_decode(file_get_contents(dirname(__FILE__).'/data.json'), true);
            
            $index = array_search($username, array_column($fileArray, 'username'));

            $person = null;
            if(is_numeric($index)){
                $person = $fileArray[$index];

            }

            return $person;
        }
    }


?>
