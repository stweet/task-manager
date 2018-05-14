<?php

namespace stweet {

    /**
     * 
     * @todo php://input
     */
    abstract
    class Input {
        
        static 
        public function any($name, $def = null) {
            $g = self::get($name);
            if (!empty($g)) return $g;

            $p = self::post($name);
            if (!empty($p)) return $p;

            return $def;
        }
        
        static 
        public function anyArray(string $name, Array $def = array()) {
            $g = self::getArray($name);
            if (!empty($g)) return $g;

            $p = self::postArray($name);
            if (!empty($p)) return $p;

            return $def;
        }
        
        static 
        public function get(string $name, $def = null) {
            if ($request = filter_input(INPUT_GET, $name)) 
                return $request;

            return $def;
        }
        
        static 
        public function getArray(string $name, Array $def = array()) {
            if (($request = filter_input_array(INPUT_GET)) && isset($request[$name])) 
                return $request[$name];
            return $def;
        }
        
        static 
        public function post(string $name, Object $def = null) {
            if ($request = filter_input(INPUT_POST, $name)) 
                return $request;
            return $def;
        }
        
        static 
        public function postArray(string $name, Array $def = array()) {
            if (($request = filter_input_array(INPUT_POST)) && isset($request[$name])) 
                return $request[$name];
            return $def;
        }
        
        static 
        public function file(string $name): Array {
            if (isset($_FILES[$name]) && is_string($_FILES[$name]["name"])) 
                return $_FILES[$name];
            return null;
        }
        
        static 
        public function fileArray(string $name): Array {

            if (isset($_FILES[$name]) && is_array($_FILES[$name]['name'])) {

                $output = array();
                for ($i = 0; $i < count($_FILES[$name]['name']); $i ++) {

                    $output[$i] = array();
                    foreach($_FILES[$name] as $field => $value)
                        $output[$i][$field] = $_FILES[$name][$field][$i];
                }

                return $output;
            }

            return [];
        }
    }
}