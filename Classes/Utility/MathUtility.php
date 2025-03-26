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

class MathUtility
{
    /**
     * Calculate a percentage value
     * @param mixed $nominator
     * @param mixed $denominator
     * @return float
     */
    public static function calculatePercentage($nominator, $denominator): float
    {
        return \round((($nominator / $denominator) * 100), 2);
    }
}
