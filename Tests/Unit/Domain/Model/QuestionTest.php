<?php

declare(strict_types=1);

namespace Wacon\Simplequiz\Tests\Unit\Domain\Model;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Kevin Chileong Lee <info@wacon.de>
 */
class QuestionTest extends UnitTestCase
{
    /**
     * @var \Wacon\Simplequiz\Domain\Model\Question|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Wacon\Simplequiz\Domain\Model\Question::class,
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
    public function getTextReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getText()
        );
    }

    /**
     * @test
     */
    public function setTextForStringSetsText(): void
    {
        $this->subject->setText('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('text'));
    }

    /**
     * @test
     */
    public function getRightAnswerReturnsInitialValueForInt(): void
    {
        self::assertSame(
            0,
            $this->subject->getRightAnswer()
        );
    }

    /**
     * @test
     */
    public function setRightAnswerForIntSetsRightAnswer(): void
    {
        $this->subject->setRightAnswer(12);

        self::assertEquals(12, $this->subject->_get('rightAnswer'));
    }
}
