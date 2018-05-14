<?php

namespace beejee\events {

    use stweet\events\Event;
    
    class TaskEvent extends Event {
        
        const ON_BEFORE_CREATE_TASK_EVENT = "onBeforeCreateTaskEvent";
        const ON_AFTER_CREATE_TASK_EVENT = "onAfterCreateTaskEvent";
        
        const ON_BEFORE_UPDATE_TASK_EVENT = "onBeforeUpdateTaskEvent";
        const ON_AFTER_UPDATE_TASK_EVENT = "onAfterUpdateTaskEvent";
    }
}