<?php

declare(strict_types=1);

namespace Wacon\Simplequiz\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wacon\Simplequiz\Domain\Repository\AnswerRepository;
use Wacon\Simplequiz\Domain\Repository\QuestionRepository;
use Wacon\Simplequiz\Domain\Repository\QuizRepository;
use Wacon\Simplequiz\Utility\PersistenceUtility;

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
     * @var string
     */
    protected $data = '';

    /**
     * Answers that user has selected
     * @var array
     */
    protected $selectedAnswers = [];

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
     * Add a question
     *
     * @param  array  $questions  Questions
     *
     * @return  self
     */
    public function addQuestion(Question $question)
    {
        if (!$this->containInQuestions($question)) {
            $this->questions[] = $question;
        }

        return $this;
    }

    /**
     * Return true, if given Question contains in $this->questions
     * @param \Wacon\Simplequiz\Domain\Model\Question $questionToSearchFor
     * @return bool
     */
    public function containInQuestions(Question $questionToSearchFor): bool
    {
        foreach ($this->questions as $question) {
            if ($question->getUid() == $questionToSearchFor->getUid()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the value of selectedAnswers
     * @return array
     */
    public function getSelectedAnswers(): array
    {
        return $this->selectedAnswers;
    }

    /**
     * Set the value of selectedAnswers
     *
     * @return  self
     */
    public function setSelectedAnswers(array $selectedAnswers)
    {
        $this->selectedAnswers = $selectedAnswers;

        return $this;
    }

    /**
     * Add a question
     *
     * @param  array  $questions  Questions
     *
     * @return  self
     */
    public function addSelectedAnswer(Answer $answer)
    {
        if (!$this->containInSelectedAnswer($answer)) {
            $this->selectedAnswers[] = $answer;
        }

        return $this;
    }

    /**
     * Return true, if given Answer contains in $this->selectedAnswer
     * @param \Wacon\Simplequiz\Domain\Model\Answer $answerToSearchFor
     * @return bool
     */
    public function containInSelectedAnswer(Answer $answerToSearchFor): bool
    {
        foreach ($this->selectedAnswers as $answer) {
            if ($answer->getUid() == $answerToSearchFor->getUid()) {
                return true;
            }
        }

        return false;
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
        $report = [];

        foreach ($this->questions as $question) {
            /**
             * @var Question $question
             */
            $answersOfQuestions = $question->getAnswers();

            $record = [
                'question' => [
                    'uid' => $question->getUid(),
                    'question' => $question->getQuestion(),
                ],
                'selectedAnswers' => [],
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

            $report[] = $record;
        }

        $this->name = $this->quiz->getName();

        $this->data = \json_encode([
            'quiz' => $this->quiz->getUid(),
            'records' => $report,
        ]);
    }

    /**
     * Get data as json
     *
     * @return  string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set data as json
     *
     * @param  string  $data  Data as json
     *
     * @return  self
     */
    public function setData(string $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Read the data json and assign all values to its properties
     * @return self
     */
    public function wakeUp()
    {
        $this->questions = [];

        // Example data
        // {"quiz":1,"report":{"question":{"uid":2,"question":"Frage 1"},"selectedAnswers":[{"uid":4,"answer":"<p>Antwort 2<\/p>","isCorrect":true}]}}
        $report = \json_decode($this->data, true);

        if (empty($report)) {
            return $this;
        }

        $quizRepository = GeneralUtility::makeInstance(QuizRepository::class);
        PersistenceUtility::disableStoragePid($quizRepository);
        $this->setQuiz($quizRepository->findByUid((int)$report['quiz']));

        foreach ($report['records'] as $record) {
            $questionRepository = GeneralUtility::makeInstance(QuestionRepository::class);
            PersistenceUtility::disableStoragePid($questionRepository);
            PersistenceUtility::disableEnabledFields($questionRepository);
            $question = $questionRepository->findByUid((int)$record['question']['uid']);

            if (!$question) {
                // If question was removed from db,
                // then add a virtual Question
                $question = new Question();
                $question->setQuestion($record['question']['question']);
            }

            $this->addQuestion($question);

            foreach ($record['selectedAnswers'] as $selectedAnswer) {
                $answerRepository = GeneralUtility::makeInstance(AnswerRepository::class);
                PersistenceUtility::disableStoragePid($answerRepository);
                PersistenceUtility::disableEnabledFields($answerRepository);

                $answer = $answerRepository->findByUid((int)$selectedAnswer['uid']);

                if (!$answer) {
                    // If answer was removed in db,
                    // then add virtual Answer
                    $answer = new Answer();
                    $answer->setAnswer($selectedAnswer['answer']);
                    $answer->setIsCorrect((bool)$selectedAnswer['isCorrect']);
                }

                $this->addSelectedAnswer($answer);
            }
        }

        return $this;
    }
}
