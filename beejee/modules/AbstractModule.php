<?php

namespace beejee\modules {
    
    use beejee\BeeJee;
    
    abstract 
    class AbstractModule {
        
        protected $beejee;

        public function __construct(BeeJee $beejee) {
            $this->beejee = $beejee;
        }
    }
}