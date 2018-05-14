<?php

namespace beejee\modules {

    use beejee\modules\AbstractModule;

    use beejee\models\UserAttributes;
    use beejee\models\UserOptions;
    use beejee\models\UserModel;
    use beejee\events\UserEvent;

    use stweet\models\ModelObject;
    
    class UsersModule extends AbstractModule {

        public function logout(string $sid) {
            
            $options = new UserOptions();
            $options->where->sid = $sid;

            $model = new UserModel($this->beejee->dbase);
            
            $result = $model->findOne($options);
            if (!$result) throw new \Exception("User not found!");

            $fields = new UserAttributes();
            $fields->sid = "null";
            
            $where = new ModelObject();
            $where->id = $result->id;
            
            $result = $model->update($where, $fields);

            $event = new UserEvent(UserEvent::ON_AFTER_LOGOUT_USER_EVENT, $result);
            $this->beejee->dispatch($event);
            return $event->target;
        }

        public function login(string $login, string $password) {
            
            $options = new UserOptions();
            $options->where->password = $password;
            $options->where->login = $login;

            $model = new UserModel($this->beejee->dbase);
            
            $result = $model->findOne($options);
            if (!$result) throw new \Exception("User not found!");

            $fields = new UserAttributes();
            $fields->sid = md5($login.":".time());
            
            $where = new ModelObject();
            $where->id = $result->id;
            
            $result = $model->update($where, $fields);

            $event = new UserEvent(UserEvent::ON_AFTER_LOGIN_USER_EVENT, $result);
            $this->beejee->dispatch($event);
            return $event->target;
        }
        
        public function auth(string $sid) {
            
            $options = new UserOptions();
            $options->where->sid = $sid;

            $model = new UserModel($this->beejee->dbase);
            
            $result = $model->findOne($options);
            if (!$result) throw new \Exception("User not found!");

            $event = new UserEvent(UserEvent::ON_AFTER_AUTH_USER_EVENT, $result);
            $this->beejee->dispatch($event);
            return $event->target;
        }
    }
}