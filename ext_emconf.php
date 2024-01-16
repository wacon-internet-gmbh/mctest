<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Simplequiz',
    'description' => 'This extension provides a simple quiz with plugins and a backend module.',
    'category' => 'misc',
    'author' => 'Philipp Kuhlmay',
    'author_email' => 'info@wacon.de',
    'state' => 'alpha',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.0.0-13.0.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
