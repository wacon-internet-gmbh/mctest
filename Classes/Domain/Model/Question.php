<?php

declare(strict_types=1);

namespace Wacon\Mctest\Domain\Model;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * This file is part of the "Mctest" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <info@wacon.de>, Wacon Internet GmbH
 */
class Question extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * text
     *
     * @var string
     */
    protected $question = '';

    /**
     * rightAnswer
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Wacon\Mctest\Domain\Model\Answer>
     */
    protected $answers;

    public function __construct()
    {
        $this->answers = new ObjectStorage();
    }

    /**
     * Get text
     *
     * @return  string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set text
     *
     * @param  string  $question  text
     *
     * @return  self
     */
    public function setQuestion(string $question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get rightAnswer
     *
     * @return  \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Wacon\Mctest\Domain\Model\Answer>
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set rightAnswer
     *
     * @param  \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Wacon\Mctest\Domain\Model\Answer> $answers
     *
     * @return  self
     */
    public function setAnswers(ObjectStorage $answers)
    {
        $this->answers = $answers;

        return $this;
    }

    /**
     * Add a Answer
     * @param \Wacon\Mctest\Domain\Model\Answer $answer
     * @return self;
     */
    public function addAnswer(Answer $answer)
    {
        $this->answers->attach($answer);
        return $this;
    }

    /**
     * Remove a Answer
     * @param \Wacon\Mctest\Domain\Model\Answer $answer
     * @return self
     */
    public function removeAnswer(Answer $answer): self
    {
        $this->answers->detach($answer);
        return $this;
    }

    /**
     * Return amount of correct answers
     * @return int
     */
    public function getAmountOfCorrectAnswers(): int
    {
        $correctAnswers = 0;

        foreach ($this->answers as $answer) {
            if ($answer->isCorrect()) {
                $correctAnswers++;
            }
        }

        return $correctAnswers;
    }
}
