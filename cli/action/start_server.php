<?php

$pathes = null;

foreach ($argv as $flag){
    $flag = strtolower($flag);
    if(!array_key_exists($flag, $cfg['run']['flags'])){
        continue;
    }

    $pathes = $cfg['run']['flags'][$flag];
    break;
}

function getStartDirectories($path = __DIR__, $arr = [])
{
    foreach (scandir($path) as $dir){
        if('.' === $dir || '..' === $dir){
            continue;
        }

        $constPath = $path . "/" . $dir;

        if(!is_file($constPath)){
            $arr = getStartDirectories($constPath, $arr);
            continue;
        }

        if(strpos($constPath, 'backup')){
            continue;
        }

        if(!strpos($constPath, '.bat')){
            continue;
        }

        $arr[] = $constPath;
    }

    return $arr;
}


$dirs = [];

if(null === $pathes){
    $dirs = getStartDirectories(BASE_PATH);
}else {
    foreach($pathes as $path) {
        $path = BASE_PATH . $path;
        $dirs = array_merge(getStartDirectories($path), $dirs);
    }
    $dirs[] = BASE_PATH . "/bungee.bat";
}

foreach($dirs as $bat){
    pclose(popen(sprintf('start cmd.exe @cmd /B /k "%s"', $bat), "r"));
    printf($lang['run']['started'], $bat);
}


