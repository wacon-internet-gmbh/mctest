<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 extension: popup_power.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Wacon\Mctest\Controller\Backend;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use Wacon\Mctest\Controller\BaseActionController;
use Wacon\Mctest\Domain\Repository\QuizSessionRepository;
use Wacon\Mctest\Domain\Statistic\DashboardStatistic;

#[AsController]
final class DashboardController extends BaseActionController
{
    protected $extensionKey = 'mctest';

    public function __construct(
        private readonly ModuleTemplateFactory $moduleTemplateFactory,
        private readonly UriBuilder $backendUriBuilder,
        private readonly QuizSessionRepository $quizSessionRepository
    ) {}

    /**
     * Start page of the DashboardStatistic
     * @return ResponseInterface
     */
    public function showAction(): ResponseInterface
    {
        $currentPageId = (int)($this->request->getQueryParams()['id'] ?? 0);

        if ($currentPageId == 0) {
            return new ForwardResponse('noPageSelected');
        }

        // fetch data from current page
        $quizSessions = $this->quizSessionRepository->findAll();

        if ($quizSessions->count() == 0) {
            return new ForwardResponse('noQuizSessionsFound');
        }

        // Process statistics to easily display statistics
        $dashboardStatistic = GeneralUtility::makeInstance(DashboardStatistic::class, $quizSessions->toArray());

        // Render template
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->assign('dashboardStatistic', $dashboardStatistic);

        return $moduleTemplate->renderResponse('Backend/Dashboard/Show');
    }

    /**
     * Displays a message that we need to select a page
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function noPageSelectedAction(): ResponseInterface
    {
        // Render template
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        return $moduleTemplate->renderResponse('Backend/Dashboard/NoPageSelected');
    }

    /**
     * Displays a message that we here are no quiz sessions
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function noQuizSessionsFoundAction(): ResponseInterface
    {
        // Render template
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        return $moduleTemplate->renderResponse('Backend/Dashboard/NoQuizSessionsFound');
    }
}
