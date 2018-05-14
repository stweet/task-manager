<?php

namespace beejee\web\controllers {
    
    use beejee\web\BeeJeeController;
    use beejee\models\TaskAttributes;
    use beejee\models\TaskOptions;

    use stweet\models\ModelObject;
    use stweet\Input;

    class TaskController extends BeeJeeController {

        static 
        public function packTaskMessage(string $message, string $type = "info") {
            return BeeJeeController::pack("task.message", ["message" => $message, "type" => $type]);
        }

        public function create() {
            $data = Input::postArray("data");

            $attributes = new TaskAttributes();
            foreach(TaskAttributes::LIST_ALLOW_FIELDS as $allow) {
                if ($data[$allow]) $attributes->$allow = $data[$allow];
            }
            
            try {
                $result = $this->beejee->tasks->create($attributes);
                echo BeeJeeController::pack('task.create', $result);
            } catch (\Exception $exc) {
                echo self::packTaskMessage($exc->getMessage(), 'danger');
            }
        }

        public function update() {
            $data = Input::postArray("data");
            
            $where = new ModelObject();
            $where->id = $data['id'];

            $fields = new TaskAttributes();
            foreach(TaskAttributes::LIST_ALLOW_FIELDS as $allow) {
                if ($data[$allow]) $fields->$allow = $data[$allow];
                else $fields->$allow = "";
            }
            
            try {
                $result = $this->beejee->tasks->update($where, $fields);
                echo BeeJeeController::pack('task.update', $result);
            } catch (\Exception $exc) {
                echo self::packTaskMessage($exc->getMessage(), 'danger');
            }
        }

        public function items() {

            $options = new TaskOptions();
            $this->prepareOptions($options);

            $pagination = $this->beejee->tasks->pagination($options);
            $pagination['index'] = ($options->offset / $options->limit);
            echo BeeJeeController::pack("task.items", $pagination);
        }

        private function prepareOptions(TaskOptions $options) {
            $filter = Input::postArray("filter");

            if (isset($filter['order']) && count($filter['order'])) {
                $options->order = $filter['order'];
            }
            
            if (isset($filter['limit']) && preg_match('/^[0-9]+$/', $filter['limit'])) {
                $options->limit = intval($filter['limit']);
            }

            if (isset($filter['index']) && preg_match('/^[0-9]+$/', $filter['index'])) {
                $options->offset = $options->limit * $filter['index'];
            }

            if (!isset($filter['where'])) return;
            foreach($filter['where'] as $key => $value) {
                $options->where->$key = $value;
            }
        }
    }
}