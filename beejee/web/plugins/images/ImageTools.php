<?php 

namespace beejee\web\plugins\images {
    
    class ImageTools {

        static 
        public function resize(string $path, int $boundWidth = 320, int $boundHeight = 240) {
            list ($imageWidth, $imageHeight) = \getimagesize($path);

            if ($imageHeight > $imageWidth) {
                $props = $boundHeight / $imageHeight;
            } else {
                $props = $boundWidth / $imageWidth;
            }
            
            $scaleHeight = $imageHeight * $props;
            $scaleWidth = $imageWidth * $props;
            $source = self::getSource($path);

            $image = imagecreatetruecolor($scaleWidth, $scaleHeight);
            imagecopyresized($image, $source, 0, 0, 0, 0, 
                $scaleWidth, $scaleHeight, $imageWidth, $imageHeight);
            return $image;
        }

        static 
        public function saveAs(string $mime, $image, string $path) {

            switch ($mime) {
                case "image/gif": self::saveAsGif($image, $path); break;
                case "image/png": self::saveAsPng($image, $path); break;
                default: self::saveAsJpg($image, $path);
            }
        }

        static 
        public function saveAsPng($image, string $path) {
            imagepng($image, $path);
        }
        
        static 
        public function saveAsJpg($image, string $path) {
            imagejpeg($image, $path, 100);
        }
        
        static 
        public function saveAsGif($image, string $path) {
            imagegif($image, $path);
        }
        
        static 
        private function getSource(string $path) {
            $imageInfo = getimagesize($path);

            switch ($imageInfo["mime"]) {
                case "image/gif": return imagecreatefromgif($path);
                case "image/png": return imagecreatefrompng($path);
                default: return imagecreatefromjpeg($path);
            }
        }
    }
}