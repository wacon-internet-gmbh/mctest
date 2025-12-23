<?php

declare(strict_types=1);

/**
 * This file is part of the "Mctest" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <info@wacon.de>, Wacon Internet GmbH
 */

namespace Wacon\Mctest\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

class IsArrayViewHelper extends AbstractConditionViewHelper
{
    protected $escapeChildren = false;

    public function initializeArguments(): void
    {
        $this->registerArgument('value', 'mixed', 'Value to check', false, false);
    }

    public function render(): string
    {
        $value = $this->arguments['value'] ? $this->arguments['value'] : $this->renderChildren();
        return \is_array($value) ? $this->renderThenChild() : $this->renderElseChild();
    }
}
