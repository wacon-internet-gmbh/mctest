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

namespace Wacon\Simplequiz\Domain\Validator;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use Wacon\Simplequiz\Bootstrap\Traits\ExtensionTrait;
use Wacon\Simplequiz\Domain\Riddler\Riddler;

class QuizSessionValidator extends AbstractValidator
{
    use ExtensionTrait;

    public function isValid(mixed $value): void
    {
        if (!isset($this->request)) {
            $request = $GLOBALS['TYPO3_REQUEST'];
        } else {
            $request = $this->request;
        }

        /**
         * @var \Wacon\Simplequiz\Domain\Model\QuizSession $quizSession
         */
        $quizSession = $value;

        $riddler = GeneralUtility::makeInstance(Riddler::class);

        if (!Riddler::hasSession($request->getAttribute('frontend.user'))) {
            $this->addError(LocalizationUtility::translate('validation.quizsession.session', $this->extensionKey), time());
        }

        $riddler->recreateFromSession($request->getAttribute('frontend.user'), $quizSession);
        $riddler->storeSessionData($request->getAttribute('frontend.user'));

        if (\count($riddler->getSelectedAnswersOfCurrentQuestion()) == 0) {
            $this->addError(LocalizationUtility::translate('validation.quizsession.selectedAnswers', $this->extensionKey), time());
        }
    }
}
