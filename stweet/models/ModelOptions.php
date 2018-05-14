<?php

namespace stweet\models {
    
    use stweet\models\ModelObject;

    class ModelOptions {

        public $attributes;
        public $where;
        public $order;
        public $limit;
        public $offset;

        public function __construct() {
            $this->attributes = [];
            $this->where = new ModelObject();
            $this->order = [['id', 'DESC']];
            $this->offset = 0;
            $this->limit = 5;
        }
    }
}