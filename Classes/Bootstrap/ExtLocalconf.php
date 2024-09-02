<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 extension: simplequiz.
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

namespace Wacon\Simplequiz\Bootstrap;

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Wacon\Simplequiz\Controller\QuizController;

class ExtLocalconf extends Base
{
    /**
     * Does the main class purpose
     */
    public function invoke()
    {
        $this->configurePlugins();
    }

    /**
     * ExtensionUtility::configurePlugin
     */
    private function configurePlugins()
    {
        ExtensionUtility::configurePlugin(
            $this->getExtensionKeyAsNamespace(),
            'Upload',
            [
                QuizController::class => 'show',
            ],
            [
                QuizController::class => 'show',
            ]
        );
    }
}
