<?php

namespace beejee {
    
    use stweet\events\EventDispatcher;

    use beejee\modules\TasksModule;
    use beejee\modules\UsersModule;
    use beejee\modules\FilesModule;
    use beejee\database\PDODriver;
    use beejee\events\BeeJeeEvent;
    use beejee\BeeJeeController;
    use beejee\BeeJeeConfig;
    
    class BeeJee extends EventDispatcher {
        
        static
        private $__inst__;

        static 
        public function inst(): \beejee\BeeJee {
            if (self::$__inst__) return self::$__inst__;

            self::$__inst__ = new self();
            self::$__inst__->registry();
            self::$__inst__->execute();
            return self::$__inst__;
        }

        private $plugins = [];

        public $dbase;
        public $tasks;
        public $users;
        public $files;

        private $controller;
        
        private function __construct() {
            $this->dbase = new PDODriver();
        }
        
        private function registry() {
            $this->tasks = new TasksModule($this);
            $this->users = new UsersModule($this);
            $this->files = new FilesModule($this);

            $this->controller = new BeeJeeController($this);
            $this->controller->registry("CLI",      "\\beejee\\console\\Application", true);
            $this->controller->registry("DELETE",   "\\beejee\\web\\Application");
            $this->controller->registry("UPDATE",   "\\beejee\\web\\Application");
            $this->controller->registry("POST",     "\\beejee\\web\\Application");
            $this->controller->registry("GET",      "\\beejee\\web\\Application");
            $this->controller->registry("PUT",      "\\beejee\\web\\Application");
        }
        
        private function execute() {
            $event = new BeeJeeEvent(BeeJeeEvent::ON_INIT_SYSTEM_EVENT, $this);
            $this->dispatch($event);
        }
    }
}