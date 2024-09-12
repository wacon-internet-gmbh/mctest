<?php

declare(strict_types=1);

namespace Wacon\Simplequiz\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use Wacon\Simplequiz\Domain\Model\Answer;

/**
 * This file is part of the "Simplequiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <info@wacon.de>, Wacon Internet GmbH
 */

/**
 * The repository for Questions
 */
class QuestionRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * Find one question record by answer
     * @param \Wacon\Simplequiz\Domain\Model\Answer $answer
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
     */
    public function findOneByAnswer(Answer $answer): QueryResult
    {
        $query = $this->createQuery();
        $query->matching(
            $query->contains('answers', $answer)
        );

        return $query->execute();
    }
}
