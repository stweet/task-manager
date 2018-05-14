<?php

namespace beejee\models {

    use beejee\models\TaskOptions;
    use beejee\database\PDODriver;
    use stweet\models\Model;
    
    class TaskModel extends Model {
        
        public function __construct(PDODriver $driver) {
            parent::__construct($driver, "tasks");
        }
    }
}