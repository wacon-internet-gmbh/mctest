<?php

declare(strict_types=1);

namespace Wacon\Simplequiz\Controller;


/**
 * This file is part of the "Simplequiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Philipp Kuhlmay <info@wacon.de>, Wacon Internet GmbH
 */

/**
 * QuizController
 */
class QuizController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * quizRepository
     *
     * @var \Wacon\Simplequiz\Domain\Repository\QuizRepository
     */
    protected $quizRepository = null;

    /**
     * @param \Wacon\Simplequiz\Domain\Repository\QuizRepository $quizRepository
     */
    public function injectQuizRepository(\Wacon\Simplequiz\Domain\Repository\QuizRepository $quizRepository)
    {
        $this->quizRepository = $quizRepository;
    }

    /**
     * action index
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $quizzes = $this->quizRepository->findAll();
        $this->view->assign('quizzes', $quizzes);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \Wacon\Simplequiz\Domain\Model\Quiz $quiz
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\Wacon\Simplequiz\Domain\Model\Quiz $quiz): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('quiz', $quiz);
        return $this->htmlResponse();
    }
}
