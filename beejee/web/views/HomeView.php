<?php

namespace beejee\web\views {
    
    use beejee\web\BeeJeeView;
    
    class HomeView extends BeeJeeView {
        
        public function __construct() {
            parent::__construct();
            
            parent::addWidget("sidebar", [], "auth");
            parent::addScriptPath("auth");
            parent::setLayout("home");
        }
    }
}