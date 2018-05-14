<?php

/**
 * 
 */
namespace beejee\console {
    
    use beejee\BeeJee;

    /**
     * 
     */
    class Application {

        private $beejee;
        private $aliases = [
            "-h" => "beejee\\console\\commands\\HelpCommand",
            "-i" => "beejee\\console\\commands\\InstallCommand",
            "-u" => "beejee\\console\\commands\\UninstallCommand",
        ];
        
        public function __construct(BeeJee $beejee) {
            $this->beejee = $beejee;
            
            $input = array_splice($GLOBALS['argv'], 1);

            if (count($input) == 0) $action = "-h";
            else $action = array_shift($input);

            if (!isset($this->aliases[$action])) {
                pre("Command '{$action}' not found!");
                pre("- php console.php -h");
            } else {
                $this->runCommand($action, $input);
            }
        }
        
        private function runCommand($action, $arguments) {
            $command = $this->aliases[$action];
            return new $command($this->beejee, $arguments);
        }
    }
}