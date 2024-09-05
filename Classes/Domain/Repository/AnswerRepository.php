<?php

declare(strict_types=1);

namespace Wacon\Simplequiz\Domain\Repository;

/**
 * This file is part of the "Simplequiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <info@wacon.de>, Wacon Internet GmbH
 */

/**
 * The repository for Answers
 */
class AnswerRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * findByUid but with array of uids
     * @param array $uids
     * @return array[]|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByUids(array $uids)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->in('uid', $uids)
        );

        return $query->execute();
    }
}
