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
 * This stores the sessions
 */
class QuizSessions extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * SessionKey
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $SessionKey = '';

    /**
     * Returns the SessionKey
     *
     * @return string
     */
    public function getSessionKey()
    {
        return $this->SessionKey;
    }

    /**
     * Sets the SessionKey
     *
     * @param string $SessionKey
     * @return void
     */
    public function setSessionKey(string $SessionKey)
    {
        $this->SessionKey = $SessionKey;
    }
}
