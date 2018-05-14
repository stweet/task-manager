<?php

namespace beejee\console\commands {

    use beejee\BeeJee;

    class HelpCommand {
        
        public function __construct(BeeJee $beejee, array $arguments = []) {
            
            pre("Тестовое задание на должность 'PHP программист' в компанию 'BeeJee'");
            
            pre("");
            pre("Консольные команды:");
            pre("php console.php -h                 - Вывод справки");
            pre("php console.php -i                 - Установка базы данных проекта");
            pre("php console.php -u                 - Удаление базы данных проекта");
            pre("php -S localhost:8000 index.php    - Локальный запуск проекта");
            
            pre("");
            pre("./install.sh                       - Установка базы данных проекта (bash)");
            pre("./uninstall.sh                     - Удаление базы данных проекта (bash)");
            pre("./server.sh                        - Локальный запуск проекта (bash)");

            pre("");
            pre("BeeJee v1.0");
        }
    }
}