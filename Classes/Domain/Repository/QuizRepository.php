<?php

declare(strict_types=1);

namespace Wacon\Mctest\Domain\Repository;

/**
 * This file is part of the "Mctest" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <info@wacon.de>, Wacon Internet GmbH
 */

/**
 * The repository for Quizzes
 */
class QuizRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function findAll()
    {
        $query = $this->createQuery();
        // get sql for createQuery
        return $this->createQuery()->execute();
    }
}
