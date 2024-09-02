<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Simplequiz',
    'description' => 'This extension provides a simple quiz with plugins and a backend module.',
    'category' => 'misc',
    'author' => 'WACON Internet GmbH',
    'author_email' => 'kevin.lee@wacon.de',
    'state' => 'alpha',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
