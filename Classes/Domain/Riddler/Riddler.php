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

namespace Wacon\Simplequiz\Domain\Riddler;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;
use Wacon\Simplequiz\Domain\Model\Answer;
use Wacon\Simplequiz\Domain\Model\Question;
use Wacon\Simplequiz\Domain\Model\QuizSession;
use Wacon\Simplequiz\Domain\Repository\AnswerRepository;
use Wacon\Simplequiz\Domain\Repository\QuestionRepository;
use Wacon\Simplequiz\Domain\Repository\QuizRepository;
use Wacon\Simplequiz\Domain\Utility\QuizUtility;

class Riddler
{
    /**
     * QuizSession model
     * @var QuizSession
     */
    protected QuizSession $quizSession;

    /**
     * Settings
     * @var array
     */
    protected array $settings = [];

    /**
     * List of random questions, created when call init
     * @var array
     */
    protected $randomQuestions = [];

    /**
     * Current step
     * @var int
     */
    protected int $currentStep = 1;

    public function __construct(
        private readonly QuizRepository $quizRepository,
        private readonly QuestionRepository $questionRepository,
        private readonly AnswerRepository $answerRepository
    ) {}

    /**
     * Init the riddler
     * @param \Wacon\Simplequiz\Domain\Model\QuizSession $quizSession
     * @return self
     */
    public function init(QuizSession $quizSession, array $settings)
    {
        $this->quizSession = $quizSession;
        $this->settings = $settings;
        $this->randomQuestions = $this->_getRandomQuestions();

        return $this;
    }

    /**
     * Return a list of random questions
     * @return array
     */
    protected function _getRandomQuestions(): array
    {
        $amountOfQuestions = $this->quizSession->getAmountOfQuestions();
        $questions = $this->quizSession->getQuiz()->getQuestions();
        $totalQuestionsCount = $questions->count();
        $selectedQuestions = [];
        $generatedNumbers = [];

        for ($i = 0; $i < $amountOfQuestions; $i++) {
            $randomQuestionIndex = $this->getUniqueRandomNumber(0, $totalQuestionsCount - 1, $generatedNumbers);
            $selectedQuestions[] = $questions->offsetGet($randomQuestionIndex);
            $generatedNumbers[] = $randomQuestionIndex;
        }

        $this->quizSession->setQuestions($selectedQuestions);

        return $selectedQuestions;
    }

    /**
     * Return a random number which are not inside the $generatedNumbers array
     * @param int $min
     * @param int $max
     * @param array $generatedNumbers
     * @param int $maxLoop
     */
    protected function getUniqueRandomNumber(int $min, int $max, array $generatedNumbers = [], int $maxLoop = 100): int
    {
        $random = rand($min, $max);

        if (in_array($random, $generatedNumbers)) {
            return $this->getUniqueRandomNumber($min, $max, $generatedNumbers, $maxLoop - 1);
        }

        return $random;
    }

    /**
     * Get QuizSession model
     *
     * @return  QuizSession
     */
    public function getQuizSession()
    {
        return $this->quizSession;
    }

    /**
     * Set quiz model
     *
     * @param  QuizSession  $quiz
     *
     * @return  self
     */
    public function setQuizSession(QuizSession $quizSession)
    {
        $this->quizSession = $quizSession;

        return $this;
    }

    /**
     * Return true if last step is reached
     * @return bool
     */
    public function getIsLastStep(): bool
    {
        return $this->getQuizSession()->getStep() >= \count($this->getQuizSession()->getQuestions());
    }

    /**
     * Increment step
     */
    public function incrementStep()
    {
        if (!$this->getIsLastStep()) {
            $this->getQuizSession()->incrementStep();
        }
    }

    /**
     * Load data from session and assign to riddler
     * @param \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication $frontendUserAuthentication
     * @param QuizSession $quizSession
     * @throws \RuntimeException
     */
    public function recreateFromSession(FrontendUserAuthentication $frontendUserAuthentication, QuizSession $quizSession = null)
    {
        $sessionData = $frontendUserAuthentication->getSessionData(QuizSession::class);

        if (!$sessionData) {
            throw new \RuntimeException('No Quiz session started.', time());
        }

        if ($quizSession) {
            $this->quizSession = $quizSession;
        } else {
            $this->quizSession = GeneralUtility::makeInstance(QuizSession::class);
        }

        $this->settings = $sessionData['settings'];

        $this->randomQuestions = [];

        foreach ($sessionData['randomQuestions'] as $questionId) {
            $this->randomQuestions[] = $this->questionRepository->findByUid($questionId);
        }

        $this->quizSession->setQuestions($this->randomQuestions);
        $this->quizSession->addSelectedAnswers($sessionData['selectedAnswers']);
        $this->quizSession->setQuiz($this->quizRepository->findByUid($sessionData['quiz']));
        $this->quizSession->setStep((int)$sessionData['step']);
        $this->quizSession->setQuizStarted((bool)$sessionData['quizStarted']);
        $this->quizSession->setAmountOfQuestions((int)$sessionData['amountOfQuestions']);
        $this->currentStep = $sessionData['currentStep'];
    }

    /**
     * Store QuizSession into Session
     * @param \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication $frontendUserAuthentication
     */
    public function storeSessionData(FrontendUserAuthentication $frontendUserAuthentication)
    {
        $selectedAnswersUidList = [];
        $selectedAnswers = $this->quizSession->getSelectedAnswers();

        foreach ($selectedAnswers as $questionId => $selectedAnswer) {
            if (is_object($selectedAnswer)) {
                $selectedAnswersUidList[$this->fetchQuestionIdForAnswer($selectedAnswer)] = $selectedAnswer->getUid();
            } else {
                $selectedAnswersUidList[$questionId] = $selectedAnswer;
            }
        }

        $randomQuestionsUidList = [];
        $randomQuestions = $this->randomQuestions;

        foreach ($randomQuestions as $randomQuestion) {
            $randomQuestionsUidList[] = $randomQuestion->getUid();
        }

        $frontendUserAuthentication->setSessionData(QuizSession::class, [
            'settings' => $this->settings,
            'randomQuestions' => $randomQuestionsUidList,
            'selectedAnswers' => $selectedAnswersUidList,
            'quiz' => $this->quizSession->getQuiz()->getUid(),
            'step' => $this->quizSession->getStep(),
            'quizStarted' => $this->quizSession->getQuizStarted(),
            'amountOfQuestions' => $this->quizSession->getAmountOfQuestions(),
            'currentStep' => $this->currentStep,
        ]);
        $frontendUserAuthentication->storeSessionData();
    }

    /**
     * Reset riddle sessions
     * @param \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication $frontendUserAuthentication
     */
    public static function resetSession(FrontendUserAuthentication $frontendUserAuthentication)
    {
        $frontendUserAuthentication->setSessionData(QuizSession::class, null);
        $frontendUserAuthentication->storeSessionData();
    }

    /**
     * Return TRUE if there is a riddle session
     * @param \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication $frontendUserAuthentication
     * @return array|false
     */
    public static function hasSession(FrontendUserAuthentication $frontendUserAuthentication)
    {
        $sessionData = $frontendUserAuthentication->getSessionData(QuizSession::class);

        return $sessionData ?? false;
    }

    /**
     * Get current step
     *
     * @return  int
     */
    public function getCurrentStep()
    {
        return $this->currentStep;
    }

    /**
     * Set current step
     *
     * @return  self
     */
    public function setCurrentStep()
    {
        $this->currentStep = $this->quizSession->getStep();

        return $this;
    }

    public function getMaxStep(): int
    {
        return \count($this->randomQuestions);
    }

    /**
     * Return true, if user has answered the current question correctly
     * @return bool
     */
    public function getIsCurrentStepAnsweredCorrectly(): bool
    {
        return QuizUtility::isQuestionAnsweredCorrectly($this->getCurrentQuestion(), $this->quizSession->getSelectedAnswers());
    }

    /**
     * Return the question of current step
     * @return Question
     */
    public function getCurrentQuestion(): Question
    {
        return $this->quizSession->getCurrentQuestion();
    }

    /**
     * Return the question of current step
     * @return array
     */
    public function getSelectedAnswersOfCurrentQuestion(): array
    {
        $question = $this->getCurrentQuestion();
        $answers = $question->getAnswers();
        $selectedAnswers = $this->quizSession->getSelectedAnswers();
        $selectedAnswersOfCurrentQuestion = [];

        foreach ($answers as $answer) {
            foreach ($selectedAnswers as $selectedAnswerId) {
                if ($selectedAnswerId == $answer->getUid()) {
                    $selectedAnswersOfCurrentQuestion[] = $answer;
                }
            }
        }

        return $selectedAnswersOfCurrentQuestion;
    }

    /**
     * Return all correct answers of current question
     * @return array
     */
    public function getCorrectAnswersOfCurrentQuestion(): array
    {
        $question = $this->quizSession->getQuestions()[$this->currentStep - 1];
        $answers = $question->getAnswers();
        $correctAnswersOfCurrentQuestion = [];

        foreach ($answers as $answer) {
            if ($answer->getIsCorrect()) {
                $correctAnswersOfCurrentQuestion[] = $answer;
            }
        }

        return $correctAnswersOfCurrentQuestion;
    }

    /**
     * Check if quiz is over
     * @return bool
     */
    public function isQuizOver(): bool
    {
        $questionsCount = $this->questionRepository->findByAnswers($this->quizSession->getSelectedAnswers())->count();
        return $this->currentStep >= $this->quizSession->getAmountOfQuestions() && count($this->randomQuestions) == $questionsCount;
    }

    /**
     * Fetch the question id for given answer
     * @param mixed $selectedAnswer
     * @return int
     */
    protected function fetchQuestionIdForAnswer($selectedAnswer): int
    {
        $question = $this->questionRepository->findOneByAnswer($selectedAnswer);
        $question = $question ? $question->current() : null;

        return $question ? $question->getUid() : 0;
    }

    /**
     * Return amount of correct answers of selected question
     * @return int
     */
    public function getAmountOfCorrectAnswersOfCurrentQuestion(): int
    {
        $question = $this->getCurrentQuestion();
        return $question->getAmountOfCorrectAnswers();
    }

    /**
     * Return amount of correct answers of selected question
     * @return int
     */
    public function getAmountOfIncorrectAnswersOfCurrentQuestion(): int
    {
        $question = $this->getCurrentQuestion();
        return \count($this->getCurrentQuestion()->getAnswers()) - $question->getAmountOfCorrectAnswers();
    }

    /**
     * Return all incorrect answers of current question
     * @return array
     */
    public function getIncorrectAnswersOfCurrentQuestion(): array
    {
        $answers = $this->getCurrentQuestion()->getAnswers();
        $selectedAnswers = $this->quizSession->getSelectedAnswers();
        $incorrectAnswers = [];

        foreach ($answers as $answer) {
            if (
                (
                    \in_array($answer->getUid(), $selectedAnswers) && !$answer->isCorrect()
                ) ||
                (
                    !\in_array($answer->getUid(), $selectedAnswers) && $answer->isCorrect()
                )
            ) {
                $incorrectAnswers[] = $answer;
            }
        }

        return $incorrectAnswers;
    }
}
