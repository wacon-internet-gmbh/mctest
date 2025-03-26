<?php

declare(strict_types=1);

namespace Wacon\Mctest\Tests\Unit\Controller;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * Test case
 *
 * @author Kevin Chileong Lee <info@wacon.de>
 */
class QuizControllerTest extends UnitTestCase
{
    /**
     * @var \Wacon\Mctest\Controller\QuizController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(\Wacon\Mctest\Controller\QuizController::class))
            ->onlyMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllQuizzesFromRepositoryAndAssignsThemToView(): void
    {
        $allQuizzes = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $quizRepository = $this->getMockBuilder(\Wacon\Mctest\Domain\Repository\QuizRepository::class)
            ->onlyMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $quizRepository->expects(self::once())->method('findAll')->willReturn($allQuizzes);
        $this->subject->_set('quizRepository', $quizRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('quizzes', $allQuizzes);
        $this->subject->_set('view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenQuizToView(): void
    {
        $quiz = new \Wacon\Mctest\Domain\Model\Quiz();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('quiz', $quiz);

        $this->subject->showAction($quiz);
    }
}
