<?php

$cfg = [
    'backup' => [
        'path' => BASE_PATH . "/backup/" . md5(time().uniqid("", true)), //Backup Path when using --bk flag
        'excluded' => [
            '.git',
            'backup',
        ],
        'silent' => true,
    ],
    'run' => [
        'flags' => [
            '-gungame' => [
                '/server/lobby',
                '/server/minigame/gungame',
            ],
        ],
    ],
    'update'=> [
        'flags' => [
            '-lobby' => [
                '/server/lobby',
            ],
            '-citybuild' => [
                '/server/citybuild',
            ],
            '-gravity' => [
                '/server/citybuild/moon',
            ],
            '-gungame' => [
                '/server/minigame/gungame',
            ],
        ],
    ],
];
