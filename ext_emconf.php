<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Simplequiz',
    'description' => 'Single and multiple-choice tests to improve user experience (UX) and increase visitor dwelling time. Ideal for learning platforms, training sessions, or simply for entertainment.',
    'category' => 'misc',
    'author' => 'WACON Internet GmbH',
    'author_email' => 'kevin.lee@wacon.de',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'version' => '3.3.2',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
