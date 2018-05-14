<?php

namespace stweet\document {

    class Widgets {

        private $widgets = [];

        public function add(string $group, string $widget) {
            if (!$this->issetGroup($group)) $this->widgets[$group] = [];
            $this->widgets[$group][] = $widget;
        }

        public function issetGroup(string $group) {
            return isset($this->widgets[$group]);
        }

        public function generateGroup(string $group) {
            if (!$this->issetGroup($group)) return "";
            return \join("", $this->widgets[$group]);
        }
    }
}