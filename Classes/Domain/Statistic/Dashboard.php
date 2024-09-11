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

use Wacon\Simplequiz\Domain\Model\QuizSession;
use Wacon\Simplequiz\Utility\MathUtility;
use Wacon\Simplequiz\Domain\Utility\QuizUtility;

class Dashboard
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

    public function __construct(array $quizSessions)
    {
        $this->quizSessions = $quizSessions;
    }

    /**
     * Return the statistics for the Dashboard
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
     * to show it in the Dashboard
     */
    protected function parseQuizSessions()
    {
        // $this->parsed = true;
        $this->statistics = [
            'quizzes' => [],
        ];

        foreach ($this->quizSessions as $quizSession) {
            // @TODO, parse data and init the object
            $quizSession->wakeUp();

            if (!\array_key_exists($quizSession->getQuiz()->getUid(), $this->statistics['quizzes'])) {
                [$correctAnswersCount, $incorrectAnswerCount] = QuizUtility::getNumberOfCorrectAndIncorrectAnswers($quizSession->getSelectedAnswers());
                $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()] = [
                    'quiz' => $quizSession->getQuiz(),
                    'sessionCount' => 1,
                    'correctAnswersCount' => $correctAnswersCount,
                    'incorrectAnswerCount' => $incorrectAnswerCount,
                    'percentageCorrect' => MathUtility::calculatePercentage($correctAnswersCount, 1),
                    'percentageWrong' => MathUtility::calculatePercentage($incorrectAnswerCount, 1),
                ];
            } else {
                [$correctAnswersCount, $incorrectAnswerCount] = QuizUtility::getNumberOfCorrectAndIncorrectAnswers($quizSession->getSelectedAnswers());
                $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['sessionCount']++;
                $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['correctAnswersCount'] += $correctAnswersCount;
                $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['incorrectAnswerCount'] += $incorrectAnswerCount;
                $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['percentageCorrect'] = MathUtility::calculatePercentage($this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['correctAnswersCount'], $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['sessionCount']);
                $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['percentageWrong'] = MathUtility::calculatePercentage($this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['incorrectAnswerCount'], $this->statistics['quizzes'][$quizSession->getQuiz()->getUid()]['sessionCount']);
            }
        }
    }
}
