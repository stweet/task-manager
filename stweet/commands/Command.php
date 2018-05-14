<?php 

namespace stweet\commands {
    
    /**
     * Undocumented class
     */
    class Command {

        /**
         * 
         * @var RegExp
         */
        private $regexp;

        /**
         * 
         * @var string
         */
        private $method;

        /**
         *
         * @var [type]
         */
        private $controller;
        
        /**
         *
         * @var array
         */
        private $reserv = [
            "int" => "[0-9]+",
            "str" => "[a-zA-Z]+",
            "any" => "[a-zA-Z0-9_-]+"
        ];
        
        /**
         *
         * @param string $rule
         * @param string $action
         */
        public function __construct(string $rule, string $action) {
            list ($controller, $method) = explode("@", $action);
            $this->controller = $controller;
            $this->method = $method;
            $this->setRule($rule);
        }

        /**
         *
         * @param string $uri
         * @return Array
         */
        public function apply(string $uri) {
            $controller = $this->controller;
            
            try {
                $arg = $this->parse($uri);
                $cls = new $controller($this);
                call_user_func_array([$cls, $this->method], $arg);
            } catch(\Exception $e) {
                echo "<pre>".$e->getMessage()."</pre>";
            }
        }

        /**
         *
         * @param string $uri
         * @return bool
         */
        public function test(string $uri): bool {
            return preg_match($this->regexp, $uri);
        }
        
        /**
         *
         * @param string $rule
         * @return void
         */
        private function setRule(string $rule) {
            $rule = "/".trim($rule, "/");

            if (strlen($rule) <= 1) {
                $this->regexp = "#^/$#";
                return;
            }
            
            $sections = [];
            foreach (explode("/", $rule) as $section) {
                if (empty($section)) continue;
                
                $matches = [];
                preg_match("#^{(\w+)}$#", $section, $matches);
                
                if (count($matches) >= 2) {
                    $name = (string) $matches[1];
                    $regx = $this->regexp($name);
                    $sections[] = "({$regx})";
                } else {
                    $sections[] = $section;
                }
            }
            
            $regexp = "/".join("/", $sections);
            $this->regexp = "#^{$regexp}$#";
        }
        
        /**
         *
         * @param string $name
         * @return void
         */
        private function regexp(string $name) {
            if (isset($this->reserv[$name]))
                return $this->reserv[$name];
            return $this->reserv["any"];
        }

        /**
         *
         * @param string $uri
         * @return Array
         */
        private function parse(string $uri): Array {
            $matches = [];

            preg_match($this->regexp, $uri, $matches);
            array_shift($matches);
            return $matches;
        }
    }
}