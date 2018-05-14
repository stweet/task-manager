<?php

namespace beejee\modules {

    use beejee\modules\AbstractModule;

    use beejee\models\TaskAttributes;
    use beejee\models\TaskOptions;
    use beejee\models\TaskModel;
    use beejee\events\TaskEvent;
    
    use stweet\models\ModelObject;
    
    class TasksModule extends AbstractModule {

        public function create(TaskAttributes $attributes) {
            $event = new TaskEvent(TaskEvent::ON_BEFORE_CREATE_TASK_EVENT, $attributes);
            $this->beejee->dispatch($event);

            $model = new TaskModel($this->beejee->dbase);
            $result = $model->insert($event->target);
            
            $event = new TaskEvent(TaskEvent::ON_AFTER_CREATE_TASK_EVENT, $result);
            $this->beejee->dispatch($event);
            return $event->target;
        }

        public function update(ModelObject $where, TaskAttributes $attributes) {
            $event = new TaskEvent(TaskEvent::ON_BEFORE_UPDATE_TASK_EVENT, $attributes);
            $this->beejee->dispatch($event);

            $model = new TaskModel($this->beejee->dbase);
            $result = $model->update($where, $event->target);
            
            $event = new TaskEvent(TaskEvent::ON_AFTER_UPDATE_TASK_EVENT, $result);
            $this->beejee->dispatch($event);

            return $event->target;
        }

        public function pagination(TaskOptions $options) {
            $model = new TaskModel($this->beejee->dbase);
            $items = $model->findAll($options);
            $count = $model->count($options);

            if ($count > 0) $count = ceil($count / $options->limit);
            return ["items" => $items, "pages" => $count];
        }
    }
}