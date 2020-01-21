<?php

$start = time();

define("BASE_PATH", __DIR__);

//$backupPath = mkdir(__DIR__ . "/backup/" . time(), 0777, true);
$backupPath = __DIR__ . "/backup/" . time();
mkdir($backupPath, 0777, true);

function backup($path = __DIR__)
{
    global $backupPath;

    foreach (scandir($path) as $file){
        if($file === "backup"){
            continue;
        }

        if('.' === $file || '..' === $file){
            continue;
        }

        $constPath = $path . "/" . $file;

        if(!is_file($constPath)){
            backup($constPath);
            continue;
        }

        $filePath = $backupPath . substr($constPath, strlen(BASE_PATH), strlen($constPath));
        $dirPath = substr($filePath, 0, strlen($filePath)-strlen($file)-1);


        if(!is_dir($dirPath)){
            mkdir($dirPath, 0777, true);
        }

        copy($constPath, $filePath);
        echo "\n\033[33mBackup of " . $filePath . " created.";
    }
}

foreach ($argv as $arg){
    switch ($arg){
        case "--bk":
        case "--backup":
            backup();
            echo "\n\033[33mBackup complete.";
            break;
    }
}

if(isset($argv[1])){
    switch ($argv[1]){
        case "update":
            require_once __DIR__ ."/action/move_plugins_to_update_directories.php";
            echo "\n\033[0mPlugin updated sucessfully finished.";
            break;
        default:
            echo "\n\033[33mNo commands given\033[0m";
            break;
    }
}

$stop = time();

echo "\n\033[32mRuntime: \033[0m" . ($stop-$start) . " seconds\n";
