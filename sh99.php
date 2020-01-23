<?php

$start = time();

define("BASE_PATH", __DIR__);
define("CMD_PATH", 'c:\WINDOWS\system32\cmd.exe');

require_once BASE_PATH . "/cli/lang/en.php";
require_once BASE_PATH . "/cli/cfg/settings.php";
require_once BASE_PATH . "/cli/func/backup.func.php";

foreach ($argv as $arg){
    switch ($arg){
        case "--bk":
        case "--backup":
            mkdir($cfg['backup']['path'], 0777, true);
            echo $lang['backup']['loading'];
            backup();
            printf($lang['backup']['complete']);
            break;
    }
}

if(isset($argv[1])){
    switch ($argv[1]){
        case "update":
            require_once __DIR__ . "/cli/action/move_plugins_to_update_directories.php";
            echo $lang['update']['complete'];
            break;
        case "run":
            require_once __DIR__ . "/cli/action/start_server.php";
            echo $lang['run']['complete'];
            break;
        default:
            echo $lang['notfound'];
            break;
    }
}

$stop = time();

printf($lang['runtime'], ($stop-$start));
