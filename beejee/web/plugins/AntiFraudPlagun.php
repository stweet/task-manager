<?php

namespace beejee\web\plugins {
    
    use beejee\events\TaskEvent;
    use beejee\BeeJee;

    class AntiFraudPlagun {

        private $beejee;

        public function __construct(BeeJee $beejee) {

            $this->beejee = $beejee;
            $this->beejee->addEventListener(TaskEvent::ON_BEFORE_CREATE_TASK_EVENT, $this);
        }
        
        public function onBeforeCreateTaskEvent(TaskEvent $event) { }
    }
}