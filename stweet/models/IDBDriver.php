<?php

namespace stweet\models {

    interface IDBDriver {

        function insert(string $query, array $attributes = null);
        function select(string $query, array $attributes = null);
        function update(string $query, array $attributes = null);
        function delete(string $query, array $attributes = null);
    }
}
