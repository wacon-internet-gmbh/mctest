<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Mctest',
    'description' => 'Single and multiple-choice tests to improve user experience (UX) and increase visitor dwelling time. Ideal for learning platforms, training sessions, or simply for entertainment.',
    'category' => 'misc',
    'author' => 'WACON Internet GmbH',
    'author_email' => 'kevin.lee@wacon.de',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'version' => '4.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-14.0.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
