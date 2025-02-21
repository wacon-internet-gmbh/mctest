<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */


/**
 * Definitions for modules provided by EXT:simplequiz
 */
return [
    'web_simplequiz_dashboard' => [
        'parent' => 'web',
        'position' => ['bottom'],
        'access' => 'user',
        'workspaces' => 'live',
        'path' => '/module/web/simplequiz',
        'labels' => 'LLL:EXT:simplequiz/Resources/Private/Language/DashboardModule/locallang_mod.xlf',
        'iconIdentifier' => 'simplequiz-plugin-simplequiz',
        'extensionName' => 'simplequiz',
        'controllerActions' => [
            \Wacon\Simplequiz\Controller\Backend\DashboardController::class => [
                'show'
            ],
        ],
    ],
];
