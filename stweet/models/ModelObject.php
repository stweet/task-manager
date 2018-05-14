<?php

namespace stweet\models {
    
    class ModelObject {
        
        private $attributes = [];
        private $length = 0;

        public function __get(string $name) {
            
            if (isset($this->attributes[$name])) {
                return $this->attributes[$name];
            }

            return null;
        }

        public function __set(string $name, $value) {
            if (!isset($this->attributes[$name])) $this->length ++;
            $this->attributes[$name] = $value;
        }
        
        public function getValueList(): array {
            return array_values($this->attributes);
        }

        public function getKeyList(): array {
            return array_keys($this->attributes);
        }

        public function getList(): array {
            return $this->attributes;
        }

        public function isEmpty(): bool {
            return $this->length == 0;
        }
    }
}