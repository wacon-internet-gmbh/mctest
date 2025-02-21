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
class AnswerReportTest extends UnitTestCase
{
    /**
     * @var \Wacon\Simplequiz\Domain\Model\AnswerReport|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Wacon\Simplequiz\Domain\Model\AnswerReport::class,
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
    public function getIdReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getId()
        );
    }

    /**
     * @test
     */
    public function setIdForStringSetsId(): void
    {
        $this->subject->setId('Conceived at T3CON10');
        self::assertTrue($this->subject->_get('isQuestionTrue'));
    }
}
