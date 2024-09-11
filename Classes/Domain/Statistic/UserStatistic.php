<?php

declare(strict_types=1);

/**
 * This file is part of the "Simplequiz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <info@wacon.de>, Wacon Internet GmbH
 */

namespace Wacon\Simplequiz\Domain\Statistic;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Wacon\Simplequiz\Domain\Model\QuizSession;
use Wacon\Simplequiz\Utility\MathUtility;
use Wacon\Simplequiz\Domain\Utility\QuizUtility;

class UserStatistic
{
    /**
     * The Dashboard Statistic, which is the overall statistic
     * @var DashboardStatistic
     */
    protected DashboardStatistic $dashboardStatistic;

    /**
     * Holds the statistic
     * @var array
     */
    protected array $statistics = [];

    /**
     * The quiz session of the user
     * @var QuizSession
     */
    protected QuizSession $quizSessionOfUser;

    /**
     * Is TRUE, when quizSession was parsed once
     * @var bool
     */
    private bool $parsed = false;

    public function __construct(QuizSession $quizSessionOfUser, array $quizSessions)
    {
        $this->quizSessionOfUser = $quizSessionOfUser;
        $this->dashboardStatistic = GeneralUtility::makeInstance(DashboardStatistic::class, $quizSessions);
    }

    /**
     * Return the statistics for the DashboardStatistic
     * @return array
     */
    public function getGet(): array
    {
        if ($this->parsed) {
            return $this->statistics;
        }

        $this->parseQuizSession();

        return $this->statistics;
    }

    /**
     * Parse the quizSessions and create a statistic array
     * to show it in the DashboardStatistic
     */
    protected function parseQuizSession()
    {
        $this->parsed = true;
        $this->statistics = [
            'quiz' => DashboardStatistic::parseQuizSession($this->quizSessionOfUser),
        ];
    }

    /**
     * Get the value of dashboardStatistic
     * @return DashboardStatistic
     */
    public function getDashboardStatistic(): DashboardStatistic
    {
        return $this->dashboardStatistic;
    }

    /**
     * Set the value of dashboardStatistic
     *
     * @return  self
     */
    public function setDashboardStatistic($dashboardStatistic)
    {
        $this->dashboardStatistic = $dashboardStatistic;

        return $this;
    }
}
