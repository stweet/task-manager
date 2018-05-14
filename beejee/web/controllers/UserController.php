<?php

namespace beejee\web\controllers {
    
    use beejee\web\BeeJeeController;
    use stweet\Input;

    class UserController extends BeeJeeController {

        static 
        public function packUserMessage(string $message, string $type = "info") {
            return BeeJeeController::pack("user.message", ["message" => $message, "type" => $type]);
        }

        public function logout() {
            
            try {
                $sid = Input::post("id");
                $result = $this->beejee->users->logout($sid);
                echo BeeJeeController::pack("user.logout", $result);
            } catch (\Exception $exc) {
                echo self::packUserMessage($exc->getMessage(), "danger");
            }
        }

        public function login() {

            try {
                $login = Input::post("login");
                $password = Input::post("password");
                $result = $this->beejee->users->login($login, $password);
                echo BeeJeeController::pack("user.login", $result);
            } catch (\Exception $exc) {
                echo self::packUserMessage($exc->getMessage(), "danger");
            }
        }

        public function auth() { 
            
            try {
                $sid = Input::post("id");
                $result = $this->beejee->users->auth($sid);
                echo BeeJeeController::pack("user.auth", $result);
            } catch (\Exception $exc) { }
        }
    }
}