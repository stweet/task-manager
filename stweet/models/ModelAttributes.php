<?php

namespace stweet\models {
    
    use stweet\models\ModelObject;

    class ModelAttributes extends ModelObject {

        // Запрещаем изменять индификатор записи в бд.
        public function __set(string $name, $value) {
            if ($name != "id") parent::__set($name, $value);
        }
    }
}