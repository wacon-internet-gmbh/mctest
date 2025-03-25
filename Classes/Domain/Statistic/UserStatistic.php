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

namespace Wacon\Simplequiz\Domain\Statistic;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use Wacon\Simplequiz\Domain\Model\QuizSession;
use Wacon\Simplequiz\Domain\Repository\AnswerRepository;
use Wacon\Simplequiz\Domain\Utility\QuizUtility;

class UserStatistic
{
    /**
     * The Dashboard Statistic, which is the overall statistic
     * @var DashboardStatistic
     */
    protected DashboardStatistic $dashboardStatistic;

    /**
     * Holds the statistic
     * @var array
     */
    protected array $statistics = [];

    /**
     * The quiz session of the user
     * @var QuizSession
     */
    protected QuizSession $quizSessionOfUser;

    /**
     * @var AnswerRepository
     */
    protected AnswerRepository $answerRepository;

    /**
     * Is TRUE, when quizSession was parsed once
     * @var bool
     */
    private bool $parsed = false;

    public function __construct(QuizSession $quizSessionOfUser, array $quizSessions, AnswerRepository $answerRepository)
    {
        $this->quizSessionOfUser = $quizSessionOfUser;
        $this->dashboardStatistic = GeneralUtility::makeInstance(DashboardStatistic::class, $quizSessions);

        // we call get to let the dashboard statistic parse
        $this->dashboardStatistic->getGet();

        $this->answerRepository = $answerRepository;
    }

    /**
     * Return the statistics for the DashboardStatistic
     * @return array
     */
    public function getGet(): array
    {
        if ($this->parsed) {
            return $this->statistics;
        }

        $this->parseQuizSession();

        return $this->statistics;
    }

    /**
     * Parse the quizSessions and create a statistic array
     * to show it in the DashboardStatistic
     */
    protected function parseQuizSession()
    {
        $this->parsed = true;
        $questions = $this->quizSessionOfUser->getQuestions();
        $questionsCount = \count($questions);
        $selectedAnswers = $this->quizSessionOfUser->getSelectedAnswers();
        $amountOfCorrectlyAnsweredQuestions = 0;

        foreach ($questions as $question) {
            foreach($selectedAnswers as $questionId => $selectedAnswerIds) {
                if ($questionId != $question->getUid()) {
                    continue;
                }
                if (QuizUtility::isQuestionAnsweredCorrectly($question, $selectedAnswerIds)) {
                    $amountOfCorrectlyAnsweredQuestions++;
                }
            }
        }

        $this->statistics = [
            'quiz' => DashboardStatistic::parseQuizSession($this->quizSessionOfUser, 1, $questionsCount, $amountOfCorrectlyAnsweredQuestions, $questionsCount - $amountOfCorrectlyAnsweredQuestions),
        ];
    }

    /**
     * Get the value of dashboardStatistic
     * @return DashboardStatistic
     */
    public function getDashboardStatistic(): DashboardStatistic
    {
        return $this->dashboardStatistic;
    }

    /**
     * Set the value of dashboardStatistic
     *
     * @return  self
     */
    public function setDashboardStatistic($dashboardStatistic)
    {
        $this->dashboardStatistic = $dashboardStatistic;

        return $this;
    }

    /**
     * Return the statistic for the quiz that user has made
     * @return array
     */
    public function getStatisticForUserQuiz(): array
    {
        return $this->dashboardStatistic->getStatisticsForQuiz($this->quizSessionOfUser->getQuiz());
    }

    /**
     * Return a QueryResult of all Answers
     * @param array $selectedAnswers
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
     */
    public function convertAsAnswerModelList(array $selectedAnswers): QueryResult
    {
        return $this->answerRepository->findByUids($selectedAnswers);
    }
}
