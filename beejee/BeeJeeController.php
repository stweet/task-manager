<?php 

/**
 * 
 */
namespace beejee {
    
    use beejee\events\BeeJeeEvent;
    use beejee\BeeJee;
    
    /**
     * 
     */
    class BeeJeeController {

        private $appliation;
        private $aliases = [];
        private $default = "";
        
        public function __construct(BeeJee $beejee) {
            $beejee->addEventListener(BeeJeeEvent::ON_INIT_SYSTEM_EVENT, $this);
        }

        public function registry(string $type, string $name, bool $default = false) {
            if ($default) $this->default = $name;
            $this->aliases[$type] = $name;
        }
        
        public function onInitSystemEvent(BeeJeeEvent $event) {
            $type = $_SERVER['REQUEST_METHOD'] ?? "CLI";
            
            if (isset($this->aliases[$type])) {
                $appliation = $this->aliases[$type];
            } else {
                $appliation = $this->default;
            }

            $this->application = new $appliation($event->target);
        }
    }
}