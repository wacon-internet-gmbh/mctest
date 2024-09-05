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

namespace Wacon\Simplequiz\Domain\Utility;

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
        $data = [0,0];

        foreach ($answers as $answer) {
            if ($answer->isCorrect()) {
                $data[0]++;
            } else {
                $data[1]++;
            }
        }

        return $data;
    }
}
