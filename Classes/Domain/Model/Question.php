<?php

declare(strict_types=1);

namespace Wacon\Simplequiz\Domain\Model;


/**
 * This file is part of the "Simplequiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Philipp Kuhlmay <info@wacon.de>, Wacon Internet GmbH
 */

/**
 * Question
 */
class Question extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * text
     *
     * @var string
     */
    protected $text = '';

    /**
     * rightAnswer
     *
     * @var int
     */
    protected $rightAnswer = 0;

    /**
     * Returns the text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Sets the text
     *
     * @param string $text
     * @return void
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * Returns the rightAnswer
     *
     * @return int
     */
    public function getRightAnswer()
    {
        return $this->rightAnswer;
    }

    /**
     * Sets the rightAnswer
     *
     * @param int $rightAnswer
     * @return void
     */
    public function setRightAnswer(int $rightAnswer)
    {
        $this->rightAnswer = $rightAnswer;
    }
}
