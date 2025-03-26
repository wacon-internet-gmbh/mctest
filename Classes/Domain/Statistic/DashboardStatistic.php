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

namespace Wacon\Mctest\Domain\Statistic;

use Wacon\Mctest\Domain\Model\Quiz;
use Wacon\Mctest\Domain\Model\QuizSession;
use Wacon\Mctest\Domain\Utility\QuizUtility;
use Wacon\Mctest\Utility\MathUtility;

class DashboardStatistic
{
    /**
     * @var array<QuizSession>
     */
    protected array $quizSessions = [];

    /**
     * Holds the statistic
     * @var array
     */
    protected array $statistics = [];

    /**
     * Is TRUE, when quizSession was parsed once
     * @var bool
     */
    private bool $parsed = false;

    /**
     * Total data
     * @var int
     */
    private \stdClass $total;

    public function __construct(array $quizSessions)
    {
        $this->quizSessions = $quizSessions;
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

        $this->parseQuizSessions();

        return $this->statistics;
    }

    /**
     * Parse the quizSessions and create a statistic array
     * to show it in the DashboardStatistic
     */
    protected function parseQuizSessions()
    {
        $this->parsed = true;
        $this->statistics = [
            'quizzes' => [],
        ];
        $this->total = new \stdClass();
        $this->total->correctAnsweredQuestions = 0;
        $this->total->sessionCount = 0;
        $this->total->questionsCount = 0;

        foreach ($this->quizSessions as $quizSession) {
            $quizSession->wakeUp();

            if (!\array_key_exists($quizSession->getQuiz()->getUid(), $this->statistics['quizzes'])) {
                [$correctAnsweredQuestions, $incorrectAnsweredQuestions] = QuizUtility::getNumberOfCorrectAndIncorrectAnsweredQuestions($quizSession->getQuestions(), $quizSession->getSelectedAnswers());
                $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()] = self::parseQuizSession($quizSession, 1, \count($quizSession->getSelectedAnswers()), $correctAnsweredQuestions, $incorrectAnsweredQuestions);
            } else {
                [$correctAnsweredQuestions, $incorrectAnsweredQuestions] = QuizUtility::getNumberOfCorrectAndIncorrectAnsweredQuestions($quizSession->getQuestions(), $quizSession->getSelectedAnswers());
                $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()] =
                    self::parseQuizSession(
                        $quizSession,
                        $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['sessionCount'] + 1,
                        $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['questionsCount'] + \count($quizSession->getQuestions()),
                        $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['correctAnsweredQuestions'] + $correctAnsweredQuestions,
                        $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['incorrectAnsweredQuestions'] + $incorrectAnsweredQuestions,
                    );
            }

            $this->total->correctAnsweredQuestions = $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['correctAnsweredQuestions'];
            $this->total->questionsCount += \count($quizSession->getQuestions());
            $this->total->sessionCount = $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['sessionCount'];
        }
    }

    /**
     * Parse a QuizSession and return parsed data as array
     * @param \Wacon\Mctest\Domain\Model\QuizSession $quizSession
     * @param int $sessionCount
     * @param int $questionsCount
     * @param int $correctAnsweredQuestions
     * @param int $incorrectAnsweredQuestions
     * @return array
     */
    public static function parseQuizSession(QuizSession $quizSession, int $sessionCount = 1, int $questionsCount = 0, int $correctAnsweredQuestions = 0, int $incorrectAnsweredQuestions = 0): array
    {
        return [
            'quiz' => $quizSession->getQuiz(),
            'sessionCount' => $sessionCount,
            'questionsCount' => $questionsCount,
            'correctAnsweredQuestions' => $correctAnsweredQuestions,
            'incorrectAnsweredQuestions' => $incorrectAnsweredQuestions,
            'percentageCorrect' => MathUtility::calculatePercentage($correctAnsweredQuestions, $questionsCount),
            'percentageWrong' => MathUtility::calculatePercentage($incorrectAnsweredQuestions, $questionsCount),
        ];
    }

    /**
     * Get the value of quizSessions
     *
     * @return  array<QuizSession>
     */
    public function getQuizSessions(): array
    {
        return $this->quizSessions;
    }

    /**
     * Set the value of quizSessions
     *
     * @param  array<QuizSession>  $quizSessions
     *
     * @return  self
     */
    public function setQuizSessions(array $quizSessions)
    {
        $this->quizSessions = $quizSessions;

        return $this;
    }

    /**
     * Get the average amount of percentage correct answers
     * @return float
     */
    public function getTotalPercentageCorrect(): float
    {
        return MathUtility::calculatePercentage($this->total->correctAnswersCount, $this->total->answersCount);
    }

    /**
     * Return statistics for a specific quiz
     * @param \Wacon\Mctest\Domain\Model\Quiz $quiz
     * @return array
     */
    public function getStatisticsForQuiz(Quiz $quiz): array
    {
        if (!array_key_exists($quiz->getUid(), $this->statistics['quizzes'])) {
            return [];
        }

        return $this->statistics['quizzes'][$quiz->getUid()];
    }
}
