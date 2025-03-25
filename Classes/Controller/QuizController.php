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

namespace Wacon\Simplequiz\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use Wacon\Simplequiz\Domain\Model\QuizSession;
use Wacon\Simplequiz\Domain\Repository\AnswerRepository;
use Wacon\Simplequiz\Domain\Repository\QuizRepository;
use Wacon\Simplequiz\Domain\Repository\QuizSessionRepository;
use Wacon\Simplequiz\Domain\Riddler\Riddler;
use Wacon\Simplequiz\Domain\Statistic\UserStatistic;

class QuizController extends BaseActionController
{
    public function __construct(
        private readonly QuizRepository $quizRepository,
        private readonly QuizSessionRepository $quizSessionRepository,
        private readonly AnswerRepository $answerRepository
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
        $quizSession->setQuizType($this->settings['quizType']);

        $this->view->assign('quizSession', $quizSession);
        $this->view->assign('contentObjectData', $this->request->getAttribute('currentContentObject')->data);

        return $this->htmlResponse();
    }

    /**
     * action solving which handle the quiz question answering process
     * @param QuizSession $quizSession
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function solvingAction(QuizSession $quizSession = null): \Psr\Http\Message\ResponseInterface
    {
        $riddler = GeneralUtility::makeInstance(Riddler::class);

        // check if session exist
        if (Riddler::hasSession($this->request->getAttribute('frontend.user'))) {
            $riddler->recreateFromSession($this->request->getAttribute('frontend.user'), $quizSession);
        } elseif ($quizSession) {
            $riddler->init($quizSession, $this->settings);
        } else {
            throw new \RuntimeException('Invalid Quiz session', time());
        }

        // check if quiz is over
        if ($riddler->isQuizOver()) {
            // store in session before we leave
            if ($quizSession) {
                $riddler->storeSessionData($this->request->getAttribute('frontend.user'));
            }

            return (new ForwardResponse('complete'))
                ->withControllerName('Quiz')
                ->withExtensionName($this->extensionKey)
                ->withArguments(['type' => $this->settings['pageTypes']['solving']]);
        }

        $riddler->getQuizSession()->setQuizStarted(true);

        // store state in session
        $riddler->storeSessionData($this->request->getAttribute('frontend.user'));

        $this->view->assign('riddler', $riddler);

        return $this->jsonResponse(\json_encode([
            'html' => $this->view->render(),
        ]));
    }

    /**
     * action answering which handle the user answer per question (quiz step)
     * @param QuizSession $quizSession
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function answeringAction(QuizSession $quizSession): \Psr\Http\Message\ResponseInterface
    {
        $riddler = GeneralUtility::makeInstance(Riddler::class);

        // check if session exist
        if (!Riddler::hasSession($this->request->getAttribute('frontend.user'))) {
            return (new ForwardResponse('complete'))
                ->withControllerName('Quiz')
                ->withExtensionName($this->extensionKey)
                ->withArguments(['type' => $this->settings['pageTypes']['solving']]);
        }

        // store state in session
        $riddler->recreateFromSession($this->request->getAttribute('frontend.user'), $quizSession);
        $riddler->storeSessionData($this->request->getAttribute('frontend.user'));

        $this->view->assign('riddler', $riddler);

        return $this->jsonResponse(\json_encode([
            'html' => $this->view->render(),
        ]));
    }

    /**
     * action complete to end the quiz and show some statistics
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function completeAction(): \Psr\Http\Message\ResponseInterface
    {
        // Create statistics
        $riddler = GeneralUtility::makeInstance(Riddler::class);

        // check if session exist
        if (!Riddler::hasSession($this->request->getAttribute('frontend.user'))) {
            return $this->jsonResponse(\json_encode([
                'html' => $this->view->render(),
            ]));
        }

        $riddler->recreateFromSession($this->request->getAttribute('frontend.user'));
        $quizSession = $riddler->getQuizSession();
        $quizSession->finalizeForDBStorage();

        $this->quizSessionRepository->add($quizSession);

        // End session
        Riddler::resetSession($this->request->getAttribute('frontend.user'));

        // Create user statistics to show it in frontend
        // fetch data from current page
        $quizSessions = $this->quizSessionRepository->findAll();

        // Process statistics to easily display statistics
        $statistic = GeneralUtility::makeInstance(UserStatistic::class, $quizSession, $quizSessions->toArray(), $this->answerRepository);
        $this->view->assign('statistic', $statistic);

        return $this->jsonResponse(\json_encode([
            'html' => $this->view->render(),
        ]));
    }
}
