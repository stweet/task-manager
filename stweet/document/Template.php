<?php

namespace stweet\document {

    use stweet\document\Widgets;
    use stweet\document\Scripts;
    use stweet\document\Styles;
    
    class Template {

        static 
        public function renderLayout(string $layout, array $args): string {
            
            \ob_start();
            \extract($args);
            require_once $layout;
            return \ob_get_clean();
        }
        
        public $layout = "";
        public $title = "";

        public $widgets;
        public $scripts;
        public $styles;
        
        public function __construct() {
            $this->widgets = new Widgets();
            $this->scripts = new Scripts();
            $this->styles = new Styles();
        }

        public function render() {
            if (!$this->layout) return "Layout not found";
            
            $scripts = $this->scripts->generatePaths();
            $scripts .= $this->scripts->generateTexts();
            
            $styles = $this->styles->generatePaths();
            $styles .= $this->styles->generateTexts();
            
            return self::renderLayout($this->layout ?? "", [
                "widgets" => $this->widgets,
                "title" => $this->title,
                "scripts" => $scripts,
                "styles" => $styles
            ]);
        }
    }
}