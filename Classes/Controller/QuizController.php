<?php

declare(strict_types=1);

namespace Wacon\Simplequiz\Controller;


use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use Wacon\Simplequiz\Domain\Repository\QuizRepository;

/**
 * This file is part of the "Simplequiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Philipp Kuhlmay <info@wacon.de>, Wacon Internet GmbH
 */

/**
 * QuizController
 */
class QuizController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    public function __construct(
        private readonly QuizRepository $quizRepository
    ) {}

    /**
     * action index
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }
}
