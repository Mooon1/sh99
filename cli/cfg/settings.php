<?php

$cfg = [
    'backup' => [
        'path' => BASE_PATH . "/backup/" . time(), //Backup Path when using --bk flag
        'excluded' => [
            '.git',
            'backup',
        ],
    ],
];
