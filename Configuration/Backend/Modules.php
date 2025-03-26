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
 * Definitions for modules provided by EXT:mctest
 */
return [
    'web_mctest_dashboard' => [
        'parent' => 'web',
        'position' => ['bottom'],
        'access' => 'user',
        'workspaces' => 'live',
        'path' => '/module/web/mctest',
        'labels' => 'LLL:EXT:mctest/Resources/Private/Language/DashboardModule/locallang_mod.xlf',
        'iconIdentifier' => 'mctest-plugin-mctest',
        'extensionName' => 'mctest',
        'controllerActions' => [
            \Wacon\Mctest\Controller\Backend\DashboardController::class => [
                'show'
            ],
        ],
    ],
];
