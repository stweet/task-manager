<?php

namespace beejee\web {
    
    use beejee\web\BeeJeeCommand;

    class BeeJeeController {
        
        static 
        public function pack(string $command, $args): string {
            return \json_encode(["cmd" => $command, "args" => $args]);
        }

        static 
        public function packMessage(string $message, string $type): string {
            return self::pack("system.message", ["message" => $message, "type" => $type]);
        }
        
        protected $command;
        protected $beejee;

        public function __construct(BeeJeeCommand $command) {
            $this->beejee = $command->beejee;
            $this->command = $command;
        }
    }
}