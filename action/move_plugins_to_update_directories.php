<?php

function getNewPlugins($path = __DIR__ . "/update")
{
    $arr = [];

    $i = 0;

    foreach (scandir($path) as $file){
        if('.' === $file || '..' === $file){
            continue;
        }

        $constPath = $path . "/" . $file;

        if(!is_file($constPath)){
            continue;
        }

        if(!strpos($constPath, '.jar')){
            continue;
        }

        $arr[$i]['path'] = $constPath;
        $arr[$i]['name'] = $file;
        ++$i;
    }

    return $arr;
}

function getUpdatesDirectories($path = __DIR__, $arr = [])
{
    foreach (scandir($path) as $dir){
        if('.' === $dir || '..' === $dir){
            continue;
        }

        $constPath = $path . "/" . $dir;

        if(is_file($constPath)){
            continue;
        }

        if('update' !== $dir){
            $arr = getUpdatesDirectories($constPath, $arr);
            continue;
        }

        if(!strpos($constPath, 'plugins')){
            continue;
        }

        $arr[] = $constPath;
    }

    return $arr;
}

$newPlugins = getNewPlugins(BASE_PATH . '/update');

$dirs = getUpdatesDirectories(BASE_PATH);
foreach ($dirs as $dir){
    foreach (scandir($dir) as $jarFile){
        $jarFilePath = $dir . "/" . $jarFile;

        if(!is_file($jarFilePath)){
            continue;
        }

        if(!strpos($jarFile, '.jar')){
            continue;
        }

        foreach ($newPlugins as $p){
            if($jarFile !== $p['name']){
                continue;
            }

            unlink($jarFilePath);
            echo "\n\033[33mJar file: " . $jarFilePath . " deleted.\033[0m";
            break;
        }
    }

    foreach ($newPlugins as $plugin){
        copy($plugin['path'], $dir . '/' . $plugin['name']);
        echo "\n\033[0mJar file: " . $plugin['name'] . " has copied to " . $dir . ".";
    }
}

