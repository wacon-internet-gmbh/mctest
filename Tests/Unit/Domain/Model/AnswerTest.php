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
class AnswerTest extends UnitTestCase
{
    /**
     * @var \Wacon\Simplequiz\Domain\Model\Answer|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Wacon\Simplequiz\Domain\Model\Answer::class,
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
    public function getAnswerReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getAnswer()
        );
    }

    /**
     * @test
     */
    public function setAnswerForStringSetsAnswer(): void
    {
        $this->subject->setAnswer('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('answer'));
    }

    /**
     * @test
     */
    public function getIsQuestionTrueReturnsInitialValueForBool(): void
    {
        self::assertFalse($this->subject->_get('isQuestionTrue'));
    }

    /**
     * @test
     */
    public function setIsQuestionTrueForBoolSetsIsQuestionTrue(): void
    {
        $this->subject->setIsQuestionTrue(true);

        self::assertTrue($this->subject->_get('isQuestionTrue'));
    }

    /**
     * @test
     */
    public function getFurtherInformationReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getFurtherInformation()
        );
    }

    /**
     * @test
     */
    public function setFurtherInformationForStringSetsFurtherInformation(): void
    {
        $this->subject->setFurtherInformation('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('furtherInformation'));
    }
}
