<?php

namespace stweet\events {
    
    use stweet\events\Event;

    class EventDispatcher {
        
        private $listeners = [];

        /**
         *
         * @param Event $event
         * @return void
         */
        public function dispatch(Event $event) {
            if (empty($this->listeners[$event->action])) return;

            foreach ($this->listeners[$event->action] as $listener) {
                if (!method_exists($listener, $event->action)) continue;
                call_user_func([$listener, $event->action], $event);
            }
        }
        
        /**
         *
         * @param string $action
         * @param [type] $listener
         * @return void
         */
        public function addEventListener(string $action, $listener) {

            if (empty($this->listeners[$action])) {
                $this->listeners[$action] = [];
            }

            $this->removeEventListener($action, $listener);
            array_push($this->listeners[$action], $listener);
        }
        
        /**
         *
         * @param string $action
         * @param [type] $listener
         * @return void
         */
        public function removeEventListener(string $action, $listener) {
            if (empty($this->listeners[$action])) return;

            for ($i = 0; $i < count($this->listeners[$action]); $i ++) {

                if ($listener == $this->listeners[$action][$i]) {
                    array_splice($this->listeners[$action], $i, 1);
                    return;
                }
            }
        }
    }
}