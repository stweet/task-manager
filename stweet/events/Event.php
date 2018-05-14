<?php

namespace stweet\events {

    /**
     * Событие
     */
    class Event {
        
        /** Тип */
        public $action;

        /** Аргументы */
        public $target;

        /**
         * 
         * @param string $action
         * @param [type] $target
         */
        public function __construct(string $action, $target) {
            $this->action = $action;
            $this->target = $target;
        }
    }
}