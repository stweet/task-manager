<?php

namespace beejee\web\plugins {
    
    use beejee\web\plugins\images\ImageTools;
    use beejee\events\FileEvent;
    use beejee\BeeJee;

    class ImageThumbsPlugin {

        private $beejee;

        public function __construct(BeeJee $beejee) {

            $this->beejee = $beejee;
            $this->beejee->addEventListener(FileEvent::ON_AFTER_UPLOAD_FILE_EVENT, $this);
        }
        
        public function onAfterUploadFileEvent(FileEvent $event) {

            $path = $event->target['path'];
            $mime = $event->target['mime'];

            $data = ImageTools::resize($path, 320, 240);
            ImageTools::saveAs($mime, $data, $path);
        }
    }
}