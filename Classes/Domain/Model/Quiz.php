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
 * Quiz which the user should answer
 */
class Quiz extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Name of the quiz
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $name = '';

    /**
     * Number of possible questions which are shown in the frontend.
     *
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $possibleQuestions = 0;

    /**
     * questions
     *
     * @var int
     */
    protected $questions = 0;

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Returns the possibleQuestions
     *
     * @return int
     */
    public function getPossibleQuestions()
    {
        return $this->possibleQuestions;
    }

    /**
     * Sets the possibleQuestions
     *
     * @param int $possibleQuestions
     * @return void
     */
    public function setPossibleQuestions(int $possibleQuestions)
    {
        $this->possibleQuestions = $possibleQuestions;
    }

    /**
     * Returns the questions
     *
     * @return int
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Sets the questions
     *
     * @param int $questions
     * @return void
     */
    public function setQuestions(int $questions)
    {
        $this->questions = $questions;
    }
}
