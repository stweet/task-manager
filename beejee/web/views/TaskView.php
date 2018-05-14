<?php

namespace beejee\web\views {
    
    use beejee\web\BeeJeeView;
    
    class TaskView extends BeeJeeView {
        
        public function __construct() {
            parent::__construct();
            
            parent::addWidget("sidebar", [], "task-btn-create");
            parent::addWidget("sidebar", [], "auth");
            
            parent::addScriptPath("tasks");
            parent::addScriptPath("auth");
            
            parent::setLayout("tasks");
        }
    }
}