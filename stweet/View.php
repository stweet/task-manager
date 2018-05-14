<?php

namespace stweet {

    use stweet\document\Template;
    
    abstract 
    class View {

        private $template;

        public function __construct() {
            $this->template = new Template();
        }

        public function setTitle(string $title) {
            $this->template->title = $title;
        }

        public function setLayout(string $layout) {
            $this->template->layout = $layout;
        }

        public function addScriptPath(string $path) {
            $this->template->scripts->addAsPath($path);
        }

        public function addScriptText(string $text) {
            $this->template->scripts->addAsText($text);
        }

        public function addStylePath(string $path) {
            $this->template->styles->addAsPath($path);
        }

        public function addStyleText(string $text) {
            $this->template->styles->addAstext($text);
        }

        public function addWidget(string $position, array $args, string $layout) {
            $widget = Template::renderLayout($layout, $args);
            $this->template->widgets->add($position, $widget);
        }

        public function render() {
            echo $this->template->render();
        } 
    }
}