<?php

namespace stweet\document {

    abstract
    class Sources {
        
        private $paths = [];
        private $texts = [];

        public function addAsPath(string $path) {
            $this->paths[] = $path;
        }

        public function addAsText(string $text) {
            $this->texts[] = $text;
        }

        public function generatePaths(): string {
            if (count($this->paths) == 0) return "";

            $output = [];
            foreach ($this->paths as $index => $path) {
                $output[] = $this->renderPath($path);
            }
            
            return \join("", $output);
        }

        public function generateTexts(): string {
            if (count($this->texts) == 0) return "";

            $texts = \join($this->texts);
            return $this->renderText($texts);
        }

        abstract 
        protected function renderPath(string $path): string;

        abstract 
        protected function renderText(string $text): string;
    }
}