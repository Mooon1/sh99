<?php

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

$batPathes = getStartDirectories(BASE_PATH);

foreach($batPathes as $bat){
    pclose(popen(sprintf('start cmd.exe @cmd /B /k "%s"', $bat), "r"));
    printf($lang['run']['started'], $bat);
}


