<?php

namespace beejee\events {

    use stweet\events\Event;
    
    class FileEvent extends Event {
        
        const ON_AFTER_UPLOAD_FILE_EVENT = "onAfterUploadFileEvent";
    }
}