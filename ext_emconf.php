<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Simplequiz',
    'description' => '',
    'category' => 'plugin',
    'author' => 'Wacon Internet GmbH',
    'author_email' => 'info@wacon.de',
    'author_company' => 'Wacon Internet GmbH',
    'state' => 'alpha',
    'clearCacheOnLoad' => 1,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
            'fluid' => '12.4.0-12.4.99'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
