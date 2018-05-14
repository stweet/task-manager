<?php

namespace beejee\web\controllers {
    
    use beejee\web\BeeJeeController;
    use beejee\modules\file\ImageDriver;
    use stweet\Input;

    class FileController extends BeeJeeController {

        static 
        public function packFileMessage(string $message, string $type = "info") {
            return BeeJeeController::pack("file.message", ["message" => $message, "type" => $type]);
        }

        public function upload() {
            try {
                $file = Input::postArray("file");
                $driver = new ImageDriver($file);
                $result = $this->beejee->files->upload($driver);
                echo BeeJeeController::pack("file.upload", $result);
            } catch (\Exception $exc) {
                echo self::packFileMessage($exc->getMessage(), "danger");
            }
        }
    }
}