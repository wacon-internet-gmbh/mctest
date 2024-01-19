<?php

declare(strict_types=1);

namespace Wacon\Simplequiz\Tests\Unit\Domain\Model;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Philipp Kuhlmay <info@wacon.de>
 */
class QuizTest extends UnitTestCase
{
    /**
     * @var \Wacon\Simplequiz\Domain\Model\Quiz|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Wacon\Simplequiz\Domain\Model\Quiz::class,
            ['dummy']
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getNameReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName(): void
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('name'));
    }

    /**
     * @test
     */
    public function getPossibleQuestionsReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getPossibleQuestions()
        );
    }

    /**
     * @test
     */
    public function setPossibleQuestionsForIntSetsPossibleQuestions(): void
    {
        $this->subject->setPossibleQuestions(12);

        self::assertEquals(12, $this->subject->_get('possibleQuestions'));
    }

    /**
     * @test
     */
    public function getQuestionsReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getQuestions()
        );
    }

    /**
     * @test
     */
    public function setQuestionsForIntSetsQuestions(): void
    {
        $this->subject->setQuestions(12);

        self::assertEquals(12, $this->subject->_get('questions'));
    }
}
