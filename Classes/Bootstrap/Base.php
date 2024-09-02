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

use TYPO3\CMS\Core\Utility\GeneralUtility;

abstract class Base
{
    protected $extensionKey = 'simplequiz';

    /**
     * Does the main class purpose
     */
    abstract public function invoke();

    /**
     * Return the extension key in Namespace writing
     * @return string
     */
    protected function getExtensionKeyAsNamespace(): string
    {
        return GeneralUtility::underscoredToUpperCamelCase($this->extensionKey);
    }

    /**
     * Return the extension key in lower case without underscores
     * @return string
     */
    protected function getExtensionKeyForFlexforms(): string
    {
        return strtolower($this->getExtensionKeyAsNamespace());
    }

    /**
     * Return the LLL path as string
     * @param string $key
     * @return string
     */
    protected function getLLL(string $key): string
    {
        return 'LLL:EXT:' . $this->extensionKey . '/Resources/Private/Language/' . $key;
    }

    /**
     * Return the path to FlexForm file
     * @param string $filename
     * @return string
     */
    protected function getFlexformPath(string $filename): string
    {
        return 'FILE:EXT:' . $this->extensionKey . '/Configuration/Flexforms/' . $filename;
    }
}
