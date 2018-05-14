<?php

namespace stweet\document {
    
    use stweet\document\Sources;

    class Styles extends Sources {
        
        protected function renderPath(string $path): string {
            return "<link href='{$path}' type='text/css' rel='stylesheet'>";
        }

        protected function renderText(string $text): string {
            return "<style type='text/css'>{$text}</style>";
        }
    }
}