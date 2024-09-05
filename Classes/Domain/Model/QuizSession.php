<?php

declare(strict_types=1);

namespace Wacon\Simplequiz\Domain\Model;

/**
 * This file is part of the "Simplequiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Philipp Kuhlmay <info@wacon.de>, Wacon Internet GmbH
 */

class QuizSession extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Related quiz
     * @var Quiz
     */
    protected Quiz $quiz;

    /**
     * Current step we are in
     * @var string
     */
    protected string $name = '';

    /**
     * Amount of chosen questions in plugin as it started
     * @var int
     */
    protected int $amountOfQuestions = 1;

    /**
     * Current step we are in
     * @var int
     */
    protected int $step = 1;

    /**
     * Is true, when user pressed start quiz button
     * @var bool
     */
    protected bool $quizStarted = false;

    /**
     * Questions
     *
     * @var array
     */
    protected $questions;

    /**
     * Data as json
     *
     * @var array
     */
    protected $data = [];

    /**
     * Answers that user has selected
     * @var array
     */
    protected $selectedAnswers = [];

    /**
     * Get data as json
     *
     * @return  array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set data as json
     *
     * @param  array  $data  Data as json
     *
     * @return  self
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get related quiz
     *
     * @return  Quiz
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * Set related quiz
     *
     * @param  Quiz  $quiz  Related quiz
     *
     * @return  self
     */
    public function setQuiz(Quiz $quiz)
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * Get amount of chosen questions in plugin as it started
     *
     * @return  int
     */
    public function getAmountOfQuestions()
    {
        return $this->amountOfQuestions;
    }

    /**
     * Set amount of chosen questions in plugin as it started
     *
     * @param  int  $amountOfQuestions  Amount of chosen questions in plugin as it started
     *
     * @return  self
     */
    public function setAmountOfQuestions(int $amountOfQuestions)
    {
        $this->amountOfQuestions = $amountOfQuestions;

        return $this;
    }

    /**
     * Get current step we are in
     *
     * @return  int
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Set current step we are in
     *
     * @param  int  $step  Current step we are in
     *
     * @return  self
     */
    public function setStep(int $step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Increment step
     * @return self
     */
    public function incrementStep()
    {
        $this->step++;

        return $this;
    }

    /**
     * Get is true, when user pressed start quiz button
     *
     * @return  bool
     */
    public function getQuizStarted()
    {
        return $this->quizStarted;
    }

    /**
     * Set is true, when user pressed start quiz button
     *
     * @param  bool  $quizStarted  Is true, when user pressed start quiz button
     *
     * @return  self
     */
    public function setQuizStarted(bool $quizStarted)
    {
        $this->quizStarted = $quizStarted;

        return $this;
    }

    /**
     * Get questions
     *
     * @return  array
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Set questions
     *
     * @param  array  $questions  Questions
     *
     * @return  self
     */
    public function setQuestions(array $questions)
    {
        $this->questions = $questions;

        return $this;
    }

    /**
     * Get the value of selectedAnswers
     */
    public function getSelectedAnswers()
    {
        return $this->selectedAnswers;
    }

    /**
     * Set the value of selectedAnswers
     *
     * @return  self
     */
    public function setSelectedAnswers($selectedAnswers)
    {
        $this->selectedAnswers = $selectedAnswers;

        return $this;
    }

    /**
     * Get current step we are in
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set current step we are in
     *
     * @param  string  $name  Current step we are in
     *
     * @return  self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Write all necessary info in $data, which is persisted
     */
    public function finalizeForDBStorage()
    {
        $answers = [];

        foreach ($this->questions as $question) {
            /**
             * @var Question $question
             */
            $answersOfQuestions = $question->getAnswers();

            $record = [
                'question' => [
                    'uid' => $question->getUid(),
                    'question' => $question->getQuestion()
                ],
                'selectedAnswers' => []
            ];

            foreach ($this->selectedAnswers as $answer) {
                /**
                 * @var Answer $answer
                 */
                foreach ($answersOfQuestions as $answerOfQuestions) {
                    if ($answerOfQuestions->getUid() == $answer->getUid()) {
                        $record['selectedAnswers'][] = [
                            'uid' => $answer->getUid(),
                            'answer' => $answer->getAnswer(),
                            'isCorrect' => $answer->isCorrect(),
                        ];
                    }
                }
            }
        }

        $this->name = $this->quiz->getName();

        $this->data = \json_encode([
            'quiz' => $this->quiz->getUid(),
            'report' => $record,
        ]);
    }
}
