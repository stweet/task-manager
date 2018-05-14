<?php

namespace beejee\models {

    use beejee\database\PDODriver;
    use stweet\models\Model;
    
    class UserModel extends Model {
        
        public function __construct(PDODriver $driver) {
            parent::__construct($driver, "users");
        }
    }
}