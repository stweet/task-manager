<?php

namespace beejee\web {
    
    use stweet\View;

    class BeeJeeView extends View {
        
        public function __construct() {
            parent::__construct();
            parent::setTitle("Task manager - v1.0");

            $this->addScriptPath("jquery-3.3.1.min");
            $this->addScriptPath("bootstrap.min");
            $this->addScriptPath("elements");
            $this->addScriptPath("beejee");
            
            $this->addStylePath("bootstrap.min");
            $this->addStylePath("beejee");
        }
        
        public function addWidget(string $group, array $args, string $layout) {
            parent::addWidget($group, $args, "./access/views/widgets/{$layout}.php");
        }
        
        public function setLayout(string $layout) {
            parent::setLayout("./access/views/layouts/{$layout}.php");
        }

        public function addScriptPath(string $path) {
            parent::addScriptPath("/access/scripts/{$path}.js");
        }

        public function addStylePath(string $path) {
            parent::addStylePath("/access/styles/{$path}.css");
        }
    }
}