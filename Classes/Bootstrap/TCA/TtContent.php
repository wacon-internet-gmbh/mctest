<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 extension: mctest.
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

namespace Wacon\Mctest\Bootstrap\TCA;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Wacon\Mctest\Bootstrap\Base;

class TtContent extends Base
{
    /**
     * Does the main class purpose
     */
    public function invoke()
    {
        $this->registerPlugins();
    }

    /**
     * ExtensionUtility::registerPlugin
     */
    private function registerPlugins()
    {
        $pluginSignature = ExtensionUtility::registerPlugin(
            $this->getExtensionKeyAsNamespace(),
            'Mctest',
            $this->getLLL('locallang_plugins.xlf:mctest.title'),
        );

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'pages,recursive';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

        ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature,
            $this->getFlexformPath('Mctest.xml')
        );
    }
}
