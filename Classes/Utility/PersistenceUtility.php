<?php

declare(strict_types=1);

/**
 * This file is part of the "Mctest" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <info@wacon.de>, Wacon Internet GmbH
 */

namespace Wacon\Mctest\Utility;

use TYPO3\CMS\Extbase\Persistence\Repository;

class PersistenceUtility
{
    /**
     * Set setRespectStoragePage to false
     * @param \TYPO3\CMS\Extbase\Persistence\Repository $repository
     */
    public static function disableStoragePid(Repository &$repository)
    {
        $querySettings = $repository->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $repository->setDefaultQuerySettings($querySettings);
    }

    /**
     * Disable the consideration of enabled fields
     * @param \TYPO3\CMS\Extbase\Persistence\Repository $repository
     */
    public static function disableEnabledFields(Repository &$repository)
    {
        $querySettings = $repository->createQuery()->getQuerySettings();
        $querySettings->setIgnoreEnableFields(true);
        $querySettings->setIncludeDeleted(true);
        $querySettings->setEnableFieldsToBeIgnored(['deleted', 'disabled', 'starttime', 'endtime']);
        $repository->setDefaultQuerySettings($querySettings);
    }
}
