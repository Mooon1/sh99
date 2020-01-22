<?php

$start = time();

define("BASE_PATH", __DIR__);


require_once BASE_PATH . "/cli/cfg/settings.php";
require_once BASE_PATH . "/cli/func/backup.func.php";

foreach ($argv as $arg){
    switch ($arg){
        case "--bk":
        case "--backup":
            backup();
            echo "\n \033[32m Backup complete. \033[0m";
            break;
    }
}

if(isset($argv[1])){
    switch ($argv[1]){
        case "update":
            require_once __DIR__ . "/cli/action/move_plugins_to_update_directories.php";
            echo "\n \033[32m Plugin updated sucessfully finished. \033[0m";
            break;
        default:
            echo "\n \033[31m No commands given \033[0m";
            break;
    }
}

$stop = time();

echo "\n \033[32m Runtime: \033[0m " . ($stop-$start) . " seconds \033[0m \n";
