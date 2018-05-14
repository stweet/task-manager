<?php

namespace beejee\web\plugins {
    
    use beejee\events\TaskEvent;
    use beejee\BeeJeeConfig;
    use beejee\BeeJee;

    class AllowCommandPlugin {

        private $beejee;

        public function __construct(BeeJee $beejee) {

            $this->beejee = $beejee;
            // $this->beejee->addEventListener(TaskEvent::ON_BEFORE_CREATE_TASK_EVENT, $this);
            $this->beejee->addEventListener(TaskEvent::ON_BEFORE_UPDATE_TASK_EVENT, $this);
        }
        
        public function onBeforeCreateTaskEvent(TaskEvent $event) {
            throw new \Exception("Error permission");
        }
        
        public function onBeforeUpdateTaskEvent(TaskEvent $event) {
            // throw new \Exception("Error permission");
            if (!$_COOKIE[BeeJeeConfig::COOKIE_NAME]) {
                throw new \Exception("Error permission");
            }
        }
    }
}