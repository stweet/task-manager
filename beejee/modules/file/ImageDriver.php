<?php

namespace beejee\modules\file {

    
    class ImageDriver {

        private $mimeTypes = [
            'image/png' => "png",
            'image/jpeg'=> "jpg",
            'image/jpg' => "jpg",
            'image/gif' => "gif",
        ];

        public $name;
        public $type;
        public $size;
        public $mime;
        public $data;
        public $path;
        
        public function __construct(Array $data = null) {
            if ($data) $this->bind($data);
        }
        
        private function bind(Array $data) {
            $this->type = $this->getTypeByMime($data['mime']);
            $this->data = $this->base64ToBlob($data['data']);
            $this->name = $this->parseName($data['name']);
            $this->size = intval($data['size']);
            $this->mime = $data['mime'];
        }
        
        private function base64ToBlob($base64) {
            $data = explode(";base64,", $base64);
            $decode = base64_decode($data[1]);
            return $decode;
        }
        
        private function getTypeByMime($mime) {
            return $this->mimeTypes[$mime] ?? 'txt';
        }
        
        private function parseName($fullname) {
            return preg_replace("/\.(png|gif|jpg|jpeg)\$/i", "", $fullname);
        }
    }
}