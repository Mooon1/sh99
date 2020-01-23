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

        if(strpos($constPath, 'backup')){
            continue;
        }

        $arr[] = $constPath;
    }

    return $arr;
}

$pathes = null;

foreach ($argv as $flag){
    $flag = strtolower($flag);
    if(!array_key_exists($flag, $cfg['update']['flags'])){
        continue;
    }

    $pathes = $cfg['update']['flags'][$flag];
    break;
}

$newPlugins = getNewPlugins(BASE_PATH . '/update');

$dirs = [];

if(null === $pathes){
    $dirs = getUpdatesDirectories(BASE_PATH);
}else {
    foreach($pathes as $path) {
        $path = BASE_PATH . $path;
        $dirs = array_merge(getUpdatesDirectories($path), $dirs);
    }
}

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
            printf($lang['update']['deleted_jar_file'], $jarFilePath);
            break;
        }
    }

    foreach ($newPlugins as $plugin){
        copy($plugin['path'], $dir . '/' . $plugin['name']);
        printf($lang['update']['copied_jar_file'], $plugin['name'], $dir);
    }
}

foreach ($newPlugins as $p){
    unlink($p['path']);
}
