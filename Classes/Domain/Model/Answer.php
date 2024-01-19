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
 * Single Answer, right or wrong
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
     * Is this question true?
     *
     * @var bool
     */
    protected $isQuestionTrue = false;

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
     * @return void
     */
    public function setAnswer(string $answer)
    {
        $this->answer = $answer;
    }

    /**
     * Returns the isQuestionTrue
     *
     * @return bool
     */
    public function getIsQuestionTrue()
    {
        return $this->isQuestionTrue;
    }

    /**
     * Sets the isQuestionTrue
     *
     * @param bool $isQuestionTrue
     * @return void
     */
    public function setIsQuestionTrue(bool $isQuestionTrue)
    {
        $this->isQuestionTrue = $isQuestionTrue;
    }

    /**
     * Returns the boolean state of isQuestionTrue
     *
     * @return bool
     */
    public function isIsQuestionTrue()
    {
        return $this->isQuestionTrue;
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
     * @return void
     */
    public function setFurtherInformation(string $furtherInformation)
    {
        $this->furtherInformation = $furtherInformation;
    }
}
