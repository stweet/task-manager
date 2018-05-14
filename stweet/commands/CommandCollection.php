<?php 

namespace stweet\commands {
    
    use stweet\commands\Command;

    class CommandCollection {

        const METHOD_POST   = "POST";
        const METHOD_GET    = "GET";
        const METHOD_CLI    = "CLI";
        
        private $commands = [
            self::METHOD_POST => [],
            self::METHOD_GET  => [],
            self::METHOD_CLI  => []
        ];
        
        /**
         *
         * @param string $method
         * @param Command $command
         * @return void
         */
        public function add(string $method, Command $command) {
            $this->commands[$method][] = $command;
        }
        
        /**
         * Метод проверяет и возвращает команду по совпадению.
         *
         * @param string $method
         * @param string $url
         * @return Command
         */
        public function get(string $method, string $uri) {
            if (empty($this->commands[$method])) return null;

            foreach ($this->commands[$method] as $command) {
                if ($command->test($uri)) {
                    return $command;
                }
            }
            
            return null;
        }
    }
}