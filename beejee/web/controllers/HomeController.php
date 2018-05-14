<?php

namespace beejee\web\controllers {
    
    use beejee\web\BeeJeeController;
    use beejee\web\views\TaskView;

    class HomeController extends BeeJeeController {

        public function index() {
            echo (new TaskView())->render();
        }

        public function getNotFound() {
            echo "get 404";
        }

        public function postNotFound() {
            echo "post 404";
        }
    }
}