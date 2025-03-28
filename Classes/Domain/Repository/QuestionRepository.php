<?php

declare(strict_types=1);

namespace Wacon\Mctest\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use Wacon\Mctest\Domain\Model\Answer;

/**
 * This file is part of the "Mctest" Extension for TYPO3 CMS.
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
     * @param \Wacon\Mctest\Domain\Model\Answer $answer
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

    /**
     * Find one question record by answer
     * @param array $answerIds
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
     */
    public function findByAnswers(array $answerIds): QueryResult
    {
        $query = $this->createQuery();
        $constraints = [];

        foreach ($answerIds as $answerId) {
            $constraints[] = $query->contains('answers', $answerId);
        }

        $query->matching(
            $query->logicalOr(
                ...$constraints
            )
        );

        return $query->execute();
    }
}
