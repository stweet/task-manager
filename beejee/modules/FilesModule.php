<?php

namespace beejee\modules {

    use beejee\modules\AbstractModule;
    use beejee\modules\file\ImageDriver;
    use beejee\events\FileEvent;
    use beejee\BeeJeeConfig;
    
    class FilesModule extends AbstractModule {
        
        public function upload(ImageDriver $driver) {

            $hash = md5($driver->name)."_".time();

            $name = "{$hash}.{$driver->type}";
            $path = BeeJeeConfig::UPLOAD_DIR."/{$name}";

            if (!file_put_contents($path, $driver->data)) 
                throw new \Exception("Error save file");
            
            $data = [
                "name" => $name,
                "path" => $path,
                "size" => $driver->size,
                "mime" => $driver->mime
            ];
            
            $event = new FileEvent(FileEvent::ON_AFTER_UPLOAD_FILE_EVENT, $data);
            $this->beejee->dispatch($event);
            return $event->target;
        }
    }
}