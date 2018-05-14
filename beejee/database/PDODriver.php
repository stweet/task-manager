<?php

namespace beejee\database {

    use beejee\database\PDOConnect;
    use stweet\models\IDBDriver;
    
    class PDODriver implements IDBDriver {

        public function insert(string $query, array $attributes = null): int {
            try {
                $statement = PDOConnect::execute($query, $attributes);
                return PDOConnect::connect()->lastInsertId();
            } catch (\Exception $exc) {
                echo "DBASE::".$exc->getMessage()."\n";
            }
        }

        public function select(string $query, array $attributes = null) {
            try {
                $statement = PDOConnect::execute($query, $attributes);
                return $statement->fetchAll(\PDO::FETCH_OBJ);
            } catch (\Exception $exc) {
                echo "DBASE::".$exc->getMessage()."\n";
            }
        }

        public function update(string $query, array $attributes = null) {
            try {
                $statement = PDOConnect::execute($query, $attributes);
                return $statement->rowCount();
            } catch (\Exception $exc) {
                echo "DBASE::".$exc->getMessage()."\n";
            }
        }

        public function delete(string $query, array $attributes = null) {
            try {
                PDOConnect::execute($query, $attributes);
            } catch (\Exception $exc) {
                echo "DBASE::".$exc->getMessage()."\n";
            }
        }
    }
}