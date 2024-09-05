<?php

declare(strict_types=1);

namespace Wacon\Simplequiz\Domain\Model;

/**
 * This file is part of the "Simplequiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <info@wacon.de>, Wacon Internet GmbH
 */


class Answer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Text of the answer
     *
     * @var string
     */
    protected $answer = '';

    /**
     * Is this question correct?
     *
     * @var bool
     */
    protected $isCorrect = false;

    /**
     * Further information which are shown after answering the question.
     *
     * @var string
     */
    protected $furtherInformation = '';

    /**
     * Returns the answer
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Sets the answer
     *
     * @param string $answer
     *
     * @return Answer
     */
    public function setAnswer(string $answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Returns the isCorrect
     *
     * @return bool
     */
    public function getIsCorrect()
    {
        return $this->isCorrect;
    }

    /**
     * Sets the isCorrect
     *
     * @param bool $isCorrect
     * @return Answer
     */
    public function setIsCorrect(bool $isCorrect)
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    /**
     * Returns the boolean state of isCorrect
     *
     * @return bool
     */
    public function isCorrect()
    {
        return $this->isCorrect;
    }

    /**
     * Returns the furtherInformation
     *
     * @return string
     */
    public function getFurtherInformation()
    {
        return $this->furtherInformation;
    }

    /**
     * Sets the furtherInformation
     *
     * @param string $furtherInformation
     * @return Answer
     */
    public function setFurtherInformation(string $furtherInformation)
    {
        $this->furtherInformation = $furtherInformation;

        return $this;
    }
}
