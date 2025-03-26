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

namespace Wacon\Mctest\Domain\Utility;

use Wacon\Mctest\Domain\Model\Answer;
use Wacon\Mctest\Domain\Model\Question;

class QuizUtility
{
    /**
     * Return the array with amount of correct and incorrect answers.
     * First index is correct and second is incorrect
     * @param array $answers
     * @return array
     */
    public static function getNumberOfCorrectAndIncorrectAnswers(array $answers): array
    {
        $data = [0, 0];

        foreach ($answers as $answer) {
            if ($answer->isCorrect()) {
                $data[0]++;
            } else {
                $data[1]++;
            }
        }

        return $data;
    }

    /**
     * Return the array with amount of correct and incorrect answered questions.
     * First index is correct and second is incorrect
     * @param array $questions
     * @param array $answers
     * @return array
     */
    public static function getNumberOfCorrectAndIncorrectAnsweredQuestions(array $questions, array $answers): array
    {
        $data = [0, 0];

        foreach ($questions as $question) {
            foreach ($answers as $questionId => $answerIds) {
                if ($questionId != $question->getUid()) {
                    continue;
                }

                if (self::isQuestionAnsweredCorrectly($question, $answerIds)) {
                    $data[0]++;
                } else {
                    $data[1]++;
                }
            }
        }

        return $data;
    }

    /**
     * Check if question is answered correctly
     * @param \Wacon\Mctest\Domain\Model\Question $question
     * @param array $selectedAnswers
     * @return bool
     */
    public static function isQuestionAnsweredCorrectly(Question $question, array $selectedAnswers): bool
    {
        $answers = $question->getAnswers();
        $amountOfCorrectAnswers = $question->getAmountOfCorrectAnswers();
        $correctAnswers = 0;
        $wrongAnswers = 0;

        foreach ($answers as $answer) {
            foreach ($selectedAnswers as $selectedAnswerId) {
                if (is_object($selectedAnswerId) && get_class($selectedAnswerId) == Answer::class) {
                    $selectedAnswerId = $selectedAnswerId->getUid();
                }
                if ($selectedAnswerId == $answer->getUid() && $answer->getIsCorrect()) {
                    $correctAnswers++;
                } elseif ($selectedAnswerId == $answer->getUid() && !$answer->getIsCorrect()) {
                    $wrongAnswers++;
                }
            }
        }

        return $correctAnswers == $amountOfCorrectAnswers && $wrongAnswers == 0;
    }
}
