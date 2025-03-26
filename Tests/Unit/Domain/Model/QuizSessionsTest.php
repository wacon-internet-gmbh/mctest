<?php

declare(strict_types=1);

namespace Wacon\Mctest\Tests\Unit\Domain\Model;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Kevin Chileong Lee <info@wacon.de>
 */
class QuizSessionsTest extends UnitTestCase
{
    /**
     * @var \Wacon\Mctest\Domain\Model\QuizSessions|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Wacon\Mctest\Domain\Model\QuizSessions::class,
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
    public function getSessionKeyReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getSessionKey()
        );
    }

    /**
     * @test
     */
    public function setSessionKeyForStringSetsSessionKey(): void
    {
        $this->subject->setSessionKey('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('SessionKey'));
    }
}
