<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

function pre(... $args) {
    if (count($args) == 1) print_r($args[0]);
    else print_r($args);
    echo "\n";
}

require_once "./vendor/autoload.php";

$_SERVER['REQUEST_METHOD'] = "CLI";

$BJ = \beejee\BeeJee::inst();
