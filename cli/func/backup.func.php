<?php


function backup($path = BASE_PATH)
{
    global $cfg;
    global $lang;

    foreach (scandir($path) as $file){
        if(in_array($file, $cfg['backup']['excluded'])){
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

        $filePath = $cfg['backup']['path'] . substr($constPath, strlen(BASE_PATH), strlen($constPath));
        $dirPath = substr($filePath, 0, strlen($filePath)-strlen($file)-1);


        if(!is_dir($dirPath)){
            mkdir($dirPath, 0777, true);
        }

        copy($constPath, $filePath);
        if(!$cfg['backup']['silent']){
            printf($lang['backup']['file_created'], $filePath);
        }
    }
}
