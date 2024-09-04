<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:simplequiz/Resources/Private/Language/locallang_db.xlf:tx_simplequiz_domain_model_quiz_session',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'searchFields' => 'session_key',
        'iconfile' => 'EXT:simplequiz/Resources/Public/Icons/Extension.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'quiz, name, data, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_simplequiz_domain_model_quizsession',
                'foreign_table_where' => 'AND {#tx_simplequiz_domain_model_quizsession}.{#pid}=###CURRENT_PID### AND {#tx_simplequiz_domain_model_quizsession}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'name' => [
            'exclude' => false,
            'label' => 'LLL:EXT:simplequiz/Resources/Private/Language/locallang_db.xlf:tx_simplequiz_domain_model_quiz_session.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
                'default' => ''
            ],
        ],
        'data' => [
            'exclude' => false,
            'label' => 'LLL:EXT:simplequiz/Resources/Private/Language/locallang_db.xlf:tx_simplequiz_domain_model_quiz_session.data',
            'description' => 'LLL:EXT:simplequiz/Resources/Private/Language/locallang_db.xlf:tx_simplequiz_domain_model_quiz_session.data.description',
            'config' => [
                'type' => 'json',
                'eval' => 'trim',
                'required' => true,
                'readOnly' => true
            ],
        ],
        'quiz' => [
            'exclude' => false,
            'label' => 'LLL:EXT:simplequiz/Resources/Private/Language/locallang_db.xlf:tx_simplequiz_domain_model_quiz',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_simplequiz_domain_model_quiz',
                'maxitems' => 1,
                'size' => 1
            ],
        ],
    ],
];
