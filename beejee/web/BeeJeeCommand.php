<?php

namespace beejee\web {
    
    use stweet\commands\Command;
    use beejee\BeeJee;

    class BeeJeeCommand extends Command {
        
        public $beejee;

        public function __construct(string $rule, string $action, BeeJee $beejee) {
            parent::__construct($rule, $action);
            $this->beejee = $beejee;
        }
    }
}