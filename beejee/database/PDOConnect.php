<?php

namespace beejee\database {

    use beejee\BeeJeeConfig;
    
    class PDOConnect {
        
        static 
        private $__inst__;
        
        static
        public function connect() {
            if (self::$__inst__) return self::$__inst__;

            $dsn = self::getDsn();
            $opt = self::getOptions();

            $user = BeeJeeConfig::DBASE_USER;
            $pass = BeeJeeConfig::DBASE_PASS;

            self::$__inst__ = new \PDO($dsn, $user, $pass, $opt);
            return self::$__inst__;
        }

        static 
        public function execute(string $query, array $attributes = null) {
            $statement = self::connect()->prepare($query);
            $statement->execute($attributes);
            return $statement;
        }
        
        static 
        private function getDsn(): string {
            $dsn  = BeeJeeConfig::DBASE_TYPE;
            $dsn .= ":dbname=";
            $dsn .= BeeJeeConfig::DBASE_NAME;
            $dsn .= ";host=";
            $dsn .= BeeJeeConfig::DBASE_HOST;
            // $dsn .= ";port=";
            // $dsn .= BeeJeeConfig::DBASE_PORT;
            return $dsn;
        }

        static 
        private function getOptions(): array {
            return [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ];
        }
    }
}