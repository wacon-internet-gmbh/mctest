<?php

declare(strict_types=1);

/**
 * This file is part of the "Simplequiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <info@wacon.de>, Wacon Internet GmbH
 */

namespace Wacon\Simplequiz\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class IsArrayViewHelper extends AbstractConditionViewHelper
{
    use CompileWithRenderStatic;

    protected $escapeChildren = false;

    public function initializeArguments()
    {
        $this->registerArgument('value', 'mixed', 'Value to check', false, false);
    }

    public function render(): string
    {
        $value = $this->arguments['value'] ? $this->arguments['value'] : $this->renderChildren();
        return \is_array($value) ? $this->renderThenChild() : $this->renderElseChild();
    }
}
