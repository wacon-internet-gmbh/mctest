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
     * Quiz type
     * @var string
     */
    protected $quizType = 'single';

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
        if ($this->quiz->getQuestions()->count() >= $amountOfQuestions) {
            $this->amountOfQuestions = $amountOfQuestions;
        } else {
            $this->amountOfQuestions = $this->quiz->getQuestions()->count();
        }

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
     * Deliver the question of the current step
     * @return \Wacon\Simplequiz\Domain\Model\Question
     */
    public function getCurrentQuestion(): ?Question
    {
        return \array_key_exists($this->step - 1, $this->questions) ? $this->questions[$this->step - 1] : null;
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
     * Return selectedAnswers for current question
     * @return array
     */
    public function getSelectedAnswersForCurrentQuestion(): array
    {
        if (\array_key_exists($this->getCurrentQuestion()->getUid(), $this->selectedAnswers) && is_array($this->selectedAnswers[$this->getCurrentQuestion()->getUid()])) {
            return $this->selectedAnswers[$this->getCurrentQuestion()->getUid()];
        }

        return [];
    }

    /**
     * Set the value of selectedAnswers
     *
     * @return  self
     */
    public function setSelectedAnswers(array $selectedAnswers)
    {
        if (count($this->selectedAnswers) == 0) {
            $this->selectedAnswers = $selectedAnswers;
            return $this;
        }

        foreach($selectedAnswers as $questionId => $answers) {
            if (!array_key_exists($questionId, $this->selectedAnswers)) {
                $this->selectedAnswers[$questionId] = $answers;
            } else {
                foreach($answers as $answer) {
                    if (!in_array($answer, $this->selectedAnswers[$questionId])) {
                        $this->selectedAnswers[$questionId][] = $answer;
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Return $this->selectedAnswers as flat, non associative, array
     * @return array
     */
    public function getSelectedAnswersAsFlatArray(): array
    {
        $flatArray = [];

        foreach($this->selectedAnswers as $answers) {
            foreach($answers as $answer) {
                if (!in_array($answer, $flatArray)) {
                    $flatArray[] = $answer;
                }
            }
        }

        return $flatArray;
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
        $answerRepository = GeneralUtility::makeInstance(AnswerRepository::class);
        PersistenceUtility::disableStoragePid($answerRepository);

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

            foreach ($this->selectedAnswers as $questionId => $answerIds) {
                if ($questionId != $question->getUid()) {
                    continue;
                }

                foreach($answerIds as $answerId) {
                    /**
                     * @var Answer $answer
                     */
                    $answer = $answerRepository->findByUid($answerId);

                    if (!$answer) {
                        throw new \LogicException('Invalid answer in Quiz Session', time());
                    }

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
            $selectedAnswerIds = [];

            foreach ($record['selectedAnswers'] as $selectedAnswer) {
                $selectedAnswerIds[] = (int)$selectedAnswer['uid'];
            }

            $this->setSelectedAnswers([
                $question->getUid() => $selectedAnswerIds
            ]);
        }

        return $this;
    }

    /**
     * Get quiz type
     *
     * @return string
     */
    public function getQuizType(): string
    {
        return $this->quizType;
    }

    /**
     * Set quiz type
     *
     * @param string  $quizType
     *
     * @return self
     */
    public function setQuizType(string $quizType): self
    {
        $this->quizType = $quizType;

        return $this;
    }
}
