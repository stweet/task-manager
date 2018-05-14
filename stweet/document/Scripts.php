<?php

namespace stweet\document {
    
    use stweet\document\Sources;

    class Scripts extends Sources {
        
        protected function renderPath(string $path): string {
            return "<script src='{$path}'></script>";
        }

        protected function renderText(string $text): string {
            return "<script type='text/javascript'>{$text}</script>";
        }
    }
}