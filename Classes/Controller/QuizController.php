<?php

declare(strict_types=1);

/**
 * This file is part of the "Simplequiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Philipp Kuhlmay <info@wacon.de>, Wacon Internet GmbH
 */

namespace Wacon\Simplequiz\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wacon\Simplequiz\Domain\Model\Quiz;
use Wacon\Simplequiz\Domain\Model\QuizSession;
use Wacon\Simplequiz\Domain\Repository\QuizRepository;
use Wacon\Simplequiz\Domain\Riddler\Riddler;

class QuizController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    protected $extensionKey = 'simplequiz';

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
        // We reset session per default, if we are showing StartQuiz screen
        Riddler::resetSession($this->request->getAttribute('frontend.user'));

        // Show Start Quiz screen
        $quizSession = GeneralUtility::makeInstance(QuizSession::class);
        $quizSession->setQuiz($this->quizRepository->findByUid($this->settings['quiz']));
        $quizSession->setAmountOfQuestions((int)$this->settings['amountOfQuestions']);

        $this->view->assign('quizSession', $quizSession);

        return $this->htmlResponse();
    }

    /**
     * action solving which handle the quiz question answering process
     * @param QuizSession $quizSession
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function solvingAction(QuizSession $quizSession): \Psr\Http\Message\ResponseInterface
    {
        $riddler = GeneralUtility::makeInstance(Riddler::class);

        // check if session exist
        if (Riddler::hasSession($this->request->getAttribute('frontend.user'))) {
            $riddler->recreateFromSession($this->request->getAttribute('frontend.user'));
        }else {
            $riddler->init($quizSession, $this->settings);
        }

        $riddler->getQuizSession()->setQuizStarted(true);
        $riddler->setCurrentStep();
        $riddler->incrementStep();

        // store state in session
        $riddler->storeSessionData($this->request->getAttribute('frontend.user'));

        $this->view->assign('riddler', $riddler);

        return $this->htmlResponse();
    }

    /**
     * action answering which handle the user answer per question (quiz step)
     * @param QuizSession $quizSession
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function answeringAction(QuizSession $quizSession): \Psr\Http\Message\ResponseInterface
    {
        $riddler = GeneralUtility::makeInstance(Riddler::class);
        $riddler->init($quizSession, $this->settings);

        // check if session exist
        if (!Riddler::hasSession($this->request->getAttribute('frontend.user'))) {
            return $this->redirect('show');
        }

        $riddler->recreateFromSession($this->request->getAttribute('frontend.user'));
        $riddler->incrementStep();

        $this->view->assign('riddler', $riddler);

        return $this->htmlResponse();
    }

    /**
     * action complete to end the quiz and show some statistics
     * @param QuizSession $quizSession
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function completeAction(QuizSession $quizSession): \Psr\Http\Message\ResponseInterface
    {
        // @TODO
        // Create statistics
        // End session

        return $this->htmlResponse();
    }
}
