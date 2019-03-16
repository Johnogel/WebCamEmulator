<?php
require_once 'DAL/db.php';
class Person{
    
    public $username;
    private $password;
    public $passwordHash;
    
    public function __construct($username, $password) {
        $db = new Database();
        
        $this->password = $password;
        
        $person = $db->getPerson($username);
        
//        throw new Exception($person);
        
        if($person != null){
            if(is_array($person)){
                
                $this->username = $person['username'];
                $this->passwordHash = $person['passwordHash'];
        
            
            }
            else{
                $this->username = $person->username;
                $this->password = $person->password;
            }
        }

        
    }
    
    public function authenticationValid(){
        
        return $this->username != null && password_verify($this->password, $this->passwordHash);
        
    }
    
}
