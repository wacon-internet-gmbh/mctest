<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Simplequiz',
        'Simplequiz',
        [
            \Wacon\Simplequiz\Controller\QuizController::class => 'list, show'
        ],
        // non-cacheable actions
        [
            \Wacon\Simplequiz\Controller\QuizController::class => ''
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    simplequiz {
                        iconIdentifier = simplequiz-plugin-simplequiz
                        title = LLL:EXT:simplequiz/Resources/Private/Language/locallang_db.xlf:tx_simplequiz_simplequiz.name
                        description = LLL:EXT:simplequiz/Resources/Private/Language/locallang_db.xlf:tx_simplequiz_simplequiz.description
                        tt_content_defValues {
                            CType = list
                            list_type = simplequiz_simplequiz
                        }
                    }
                }
                show = *
            }
       }'
    );
})();
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder