<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Simplequiz',
    'description' => 'This extension provides a simple quiz with plugins and a backend module.',
    'category' => 'misc',
    'author' => 'WACON Internet GmbH',
    'author_email' => 'kevin.lee@wacon.de',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'version' => '3.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
