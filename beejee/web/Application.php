<?php

/**
 * 
 */
namespace beejee\web {
    
    use stweet\commands\CommandCollection;

    use beejee\web\plugins\AllowCommandPlugin;
    use beejee\web\plugins\ImageThumbsPlugin;
    use beejee\web\plugins\AntiFraudPlagun;
    use beejee\web\BeeJeeCommand;
    use beejee\BeeJee;

    /**
     * 
     */
    class Application {

        private $path = "beejee\\web\\controllers\\";

        private $collection;
        private $plugins;
        private $beejee;
        
        public function __construct(BeeJee $beejee) {

            $this->beejee = $beejee;
            $this->collection = new CommandCollection();
            
            $this->plugins = [];
            $this->plugins[] = new AntiFraudPlagun($beejee);
            $this->plugins[] = new ImageThumbsPlugin($beejee);
            $this->plugins[] = new AllowCommandPlugin($beejee);

            $this->registryControllers();
            $this->runApplication();
        }

        /** Для комфорта добавил пару методов регистрации команд */

        /** Регистрирует POST запросы */
        private function registryPost(string $rule, string $action) {
            $this->collection->add(CommandCollection::METHOD_POST, 
                new BeeJeeCommand($rule, $this->path.$action, $this->beejee));
        }
        
        /** Регистрирует GET запросы */
        private function registryGet(string $rule, string $action) {
            $this->collection->add(CommandCollection::METHOD_GET, 
                new BeeJeeCommand($rule, $this->path.$action, $this->beejee));
        }

        private function registryControllers() {
            $this->registryGet("/",             "HomeController@index");
            $this->registryGet("/404",          "HomeController@getNotFound");
            $this->registryPost("/404",         "HomeController@postNotFound");
            
            $this->registryPost("/task-create", "TaskController@create");
            $this->registryPost("/task-update", "TaskController@update");
            $this->registryPost("/task-items",  "TaskController@items");

            $this->registryPost("/user-logout", "UserController@logout");
            $this->registryPost("/user-login",  "UserController@login");
            $this->registryPost("/user-auth",   "UserController@auth");

            $this->registryPost("/file-upload", "FileController@upload");
        }

        private function runApplication( ) {
            $uri = "/".trim($_SERVER['REQUEST_URI'], "/");
            $method = trim($_SERVER['REQUEST_METHOD']);
            
            $command = $this->collection->get($method, $uri);
            if ($command) return $command->apply($uri);
            
            $_SERVER['REQUEST_URI'] = "/404";
            $this->runApplication();
        }
    }
}