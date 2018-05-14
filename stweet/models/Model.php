<?php

namespace stweet\models {

    use stweet\models\ModelAttributes;
    use stweet\models\ModelOptions;
    use stweet\models\ModelObject;
    use stweet\models\IDBDriver;

    class Model {
        
        private $driver;
        private $table;
        
        public function __construct(IDBDriver $driver, string $table) {
            $this->driver = $driver;
            $this->table = $table;
        }
        
        public function insert(ModelAttributes $attributes) {
            
            $list = $attributes->getKeyList();
            $keys = $this->keysToString($list);
            $attr = $attributes->getList();

            $sql = "INSERT INTO `{$this->table}` SET {$keys}";
            $id = $this->driver->insert($sql, $attr);
            return $this->findByID($id);
        }
        
        public function update(ModelObject $where, ModelAttributes $fields) {

            $keysFields = $this->keysToString($fields->getKeyList());
            $keysWhere = $this->keysToString($where->getKeyList(), " AND ");
            $attributes = \array_merge($where->getList(), $fields->getList());
            
            $sql = "UPDATE `{$this->table}` SET {$keysFields} WHERE {$keysWhere}";
            $result = $this->driver->update($sql, $attributes);

            if ($result == 0) throw new \Exception("Not update data!");

            $options = new ModelOptions();
            $options->where = $where;
            $options->limit = 0;
            
            if ($result == 1) return $this->findOne($options);
            else return $this->findAll($options);
        }

        public function delete(ModelObject $where) {
            $keysWhere = $this->keysToString($where->getKeyList(), " AND ");
            $sql = "DELETE FROM `{$this->table}` WHERE {$keysWhere}";
            $this->driver->delete($sql, $where->getList());
            return true;
        }

        public function findByID(int $id) {
            $options = new ModelOptions();
            $options->where->id = $id;
            
            return $this->findOne($options);
        }

        public function findOne(ModelOptions $options) {

            $list = $options->where->getKeyList();
            $keys = $this->keysToString($list, " AND ");
            
            if (count($options->attributes) == 0) $attr = "*";
            else $attr = $this->attributesToString($options->attributes);

            $sql = "SELECT {$attr} FROM `{$this->table}` WHERE {$keys} ORDER BY `id` DESC LIMIT 1";
            $items = $this->driver->select($sql, $options->where->getList());
            return count($items) == 0 ? null : $items[0];
        }

        public function findAll(ModelOptions $options) {
            
            $query = [];
            $this->prepareSelect($query, $options);
            
            $query[] = "FROM `{$this->table}`";

            $this->prepareWhere($query, $options);
            $this->prepareOrder($query, $options);
            $this->prepareLimit($query, $options);
            $this->prepareOffset($query, $options);
            
            $sql = join(" ", $query);
            return $this->driver->select($sql, $options->where->getList());
        }
        
        public function count(ModelOptions $options) {
            
            $query = ["SELECT COUNT(*) as count FROM `{$this->table}`"];
            $this->prepareWhere($query, $options);
            
            $sql = join(" ", $query);
            $result = $this->driver->select($sql, $options->where->getList());
            return count($result) == 0 ? 0 : $result[0]->count;
        }

        private function prepareSelect(array &$query, ModelOptions $options) {
            
            if (count($options->attributes) == 0) $attr = "*";
            else $attr = $this->attributesToString($options->attributes);

            $query[] = "SELECT {$attr}";
        }

        private function prepareWhere(array &$query, ModelOptions $options) {
            if ($options->where->isEmpty()) return;
            
            $list = $options->where->getKeyList();
            $keys = $this->keysToString($list, " AND ");

            $query[] = "WHERE {$keys}";
        }

        private function prepareOrder(array &$query, ModelOptions $options) {
            if (count($options->order) == 0) return;

            $orders = [];
            foreach ($options->order as $order) {
                list ($key, $sort) = $order;
                $orders[] = "`{$key}` {$sort}";
            }

            $query[] = "ORDER BY ".join(", ", $orders);
        }

        private function prepareOffset(array &$query, ModelOptions $options) {
            if ($options->offset > 0) $query[] = "OFFSET {$options->offset}";
        }

        private function prepareLimit(array &$query, ModelOptions $options) {
            if ($options->limit > 0) $query[] = "LIMIT {$options->limit}";
        }

        private function keysToString(array $keys, string $delimetr = ", ", array $output = []): string {
            for ($i = 0; $i < count($keys); $i ++) $output[] = "`{$keys[$i]}`=:{$keys[$i]}";
            return join($delimetr, $output);
        }

        private function attributesToString(array $attributes, array $output = []): string {
            foreach ($attributes as $attribute) $output[] = "`{$attribute}`";
            return join(", ", $output);
        }
    }
}