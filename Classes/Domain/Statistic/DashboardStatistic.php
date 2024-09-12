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

use Wacon\Simplequiz\Domain\Model\Quiz;
use Wacon\Simplequiz\Domain\Model\QuizSession;
use Wacon\Simplequiz\Domain\Utility\QuizUtility;
use Wacon\Simplequiz\Utility\MathUtility;

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
        $this->total->correctAnswersCount = 0;
        $this->total->sessionCount = 0;
        $this->total->answersCount = 0;

        foreach ($this->quizSessions as $quizSession) {
            $quizSession->wakeUp();

            if (!\array_key_exists($quizSession->getQuiz()->getUid(), $this->statistics['quizzes'])) {
                [$correctAnswersCount, $incorrectAnswerCount] = QuizUtility::getNumberOfCorrectAndIncorrectAnswers($quizSession->getSelectedAnswers());
                $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()] = self::parseQuizSession($quizSession, 1, \count($quizSession->getSelectedAnswers()), $correctAnswersCount, $incorrectAnswerCount);
            } else {
                [$correctAnswersCount, $incorrectAnswerCount] = QuizUtility::getNumberOfCorrectAndIncorrectAnswers($quizSession->getSelectedAnswers());
                $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()] =
                    self::parseQuizSession(
                        $quizSession,
                        $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['sessionCount'] + 1,
                        $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['answerCount'] + \count($quizSession->getSelectedAnswers()),
                        $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['correctAnswersCount'] + $correctAnswersCount,
                        $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['incorrectAnswerCount'] + $incorrectAnswerCount,
                    );
            }

            $this->total->correctAnswersCount = $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['correctAnswersCount'];
            $this->total->answersCount += \count($quizSession->getSelectedAnswers());
            $this->total->sessionCount = $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['sessionCount'];
        }
    }

    /**
     * Parse a QuizSession and return parsed data as array
     * @param \Wacon\Simplequiz\Domain\Model\QuizSession $quizSession
     * @param int $sessionCount
     * @param int $answerCount
     * @param int $correctAnswersCount
     * @param int $incorrectAnswersCount
     * @return array
     */
    public static function parseQuizSession(QuizSession $quizSession, int $sessionCount = 1, int $answerCount = 0, int $correctAnswersCount = 0, int $incorrectAnswersCount = 0): array
    {
        return [
            'quiz' => $quizSession->getQuiz(),
            'sessionCount' => $sessionCount,
            'answerCount' => $answerCount,
            'correctAnswersCount' => $correctAnswersCount,
            'incorrectAnswerCount' => $incorrectAnswersCount,
            'percentageCorrect' => MathUtility::calculatePercentage($correctAnswersCount, $answerCount),
            'percentageWrong' => MathUtility::calculatePercentage($incorrectAnswersCount, $answerCount),
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
     * @param \Wacon\Simplequiz\Domain\Model\Quiz $quiz
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
