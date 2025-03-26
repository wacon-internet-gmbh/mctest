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

namespace Wacon\Mctest\ViewHelpers\Riddler;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use Wacon\Mctest\Domain\Riddler\Riddler;

class IncrementStepViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): string {
        // increment step
        $riddler = GeneralUtility::makeInstance(Riddler::class);
        $riddler->recreateFromSession($renderingContext->getRequest()->getAttribute('frontend.user'));
        $riddler->incrementStep();
        $riddler->setCurrentStep();
        $riddler->storeSessionData($renderingContext->getRequest()->getAttribute('frontend.user'));

        return $renderChildrenClosure() ?? '';
    }
}
