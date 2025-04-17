# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [3.4.2]
- [BUGFIX] Quiz with single choice could not end due unsufficient support for single and multiple choise answer format

## [3.4.1]
- [BUGFIX] QuizSession->getSelectedAnswersForCurrentQuestion: Supports now single and multiple choice answer format

## [3.4.0]
- [IMPORTANT] No code changes, but rename extension from simplequiz to mctest. It is important to rename the db tables manually, Re-assign TypoScript Static File

## [3.3.2]
- [BUGFIX] Workaround for TYPO3 12 in QuizSessionValidator to access session data

## [3.3.1]
- [BUGFIX] Selected Answers are now correctly saved as assoc with question id
- [BUGFIX] Create QuizSessionValidator to force to select answers and avoid resulting errors
- [BUGFIX] QuizUtility->isQuestionAnsweredCorrectly: Consider wrong answer selection too

## [3.3.0]
- [FEATURE] Add legend to display current and max step
- [CHANGE] Remove Further information, when correctly answered
- [CHANGE] CSS Improvement of Typography

## [3.2.0]
- [FEATURE] Add quizType to FlexForm to toggle form radio or checkbox
- [CHANGE] Remove listing below wrong answers, because it needs more distinction between wrong answers and missing correct answers, which may confuse the user. I think its sufficient to say that question is wrong answered with listing of all correct answers.
- [CHANGE] Change extension description

## [3.1.0]
- [IMPORTANT] Release of 3.1.0 with multiple answer feature

## [dev-3.1.0-2]
- [FEATURE] Adjust Backend module statistic to multiple answers

## [dev-3.1.0-1]
- [WIP] Adjust Backend module statistic to multiple answers
- [FEATURE] Calculation for quiz result adjusted to multiple correct answers

## [dev-3.1.0-1]
- [WIP] Calculation for quiz result adjusted to multiple correct answers
- [FEATURE] Answering output need to conside multiple correct answers

## [dev-3.1.0-1]
- [WIP] Answering output need to conside multiple correct answers
- [FEATURE] Print possible answers as checkbox, if more than one is correct

## [dev-3.1.0-0]
- [FEATURE] Use checkbox, if there is more than one correct answer

## [3.0.0]
- [IMPORTANT] Official release 3.0.0

## [dev-3.0.0-0]
- [FEATURE] Migrate Simplified ext:backend ModuleTemplate API (https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/12.0/Feature-96730-SimplifiedExtbackendModuleTemplateAPI.html)

## [2.0.0]
- [IMPORTANT] Offical release of new version

## [dev-2.0.0-18]
- [FEATURE] Add font colors for the background color sections

## [dev-2.0.0-17]
- [FEATURE] Add some css styling

## [dev-2.0.0-16]
- [FEATURE] Correctly save step to handle correct question and question result

## [dev-2.0.0-15]
- [WIP] Correctly save step to handle correct question and question result

## [dev-2.0.0-14]
- [FEATURE] Debugging error on DB saving. Data too long
- [BUGFIX] Correcty Loop through question and answer until complete
- [BUGFIX] Calculation of UserStatistic and DashboardStatistic due amount of questions

## [dev-2.0.0-13]
- [WIP] Debugging error on DB saving. Data too long
- [FEATURE] Loop solving->answer until all questions are completet
- [FEATURE] Changing the storage of selectedAnswers

## [dev-2.0.0-12]
- [WIP] Bugfix Error, when question count is higher than 1
- [WIP] Loop solving->answer until all questions are completet
- [WIP] Changing the storage of selectedAnswers

## [dev-2.0.0-11]
- [FEATURE] Add style.css with basic styling
- [FEATURE] Add PageType Route for AJAX call
- [BUGIFX] Rename to change loading order of TypoScript files
- [WIP] Bugfix Error, when question count is higher than 1

## [dev-2.0.0-10]
- [FEATURE] Show UserStatistics

## [dev-2.0.0-9]
- [WIP] Show UserStatistics
- [FEATURE] Calculate percentage correct and wrong
- [BUGFIX] Avoid double init in JavaScript of the form during mutation observer

## [dev-2.0.0-7]
- [FEATURE] Create backend module with DashboardStatistic statistics
- [WIP] Calculate percentage correct and wrong

## [dev-2.0.0-6]
- [FEATURE] Create Riddler class to handle Quiz business logic (completeAction should clean Session)
- [FEATURE] Introduce AJAX Calls

## [dev-2.0.0-5]
- [WIP] Create Riddler class to handle Quiz business logic (completeAction should clean Session)
- [FEATURE] Persist QuizSession with Report

## [dev-2.0.0-4]
- [WIP] Quiz Frontend Plugin Frontend
- [WIP] Create Riddler class to handle Quiz business logic (completeAction is missing)
- [FEATURE] Quiz now correctly ends in completeAction after all questions are answered

## [dev-2.0.0-3]
- [WIP] Quiz Frontend Plugin Frontend
- [WIP] Create Riddler class to handle Quiz business logic (completeAction is missing)
- [FEATURE] solving and answeringAction is implemented

## [dev-2.0.0-2]
- [WIP] Quiz Frontend Plugin Frontend
- [WIP] Create Riddler class to handle Quiz business logic
- [IMPORTANT] Rename Quizsessions to singular and use it also has DomainObject for quiz session / Riddler
- [FEATURE] Updated Model classes to new TCA

## [dev-2.0.0-1]
- [IMPORTANT] Rework all model to comply to the relational database model
- [IMPORTANT] Rework TCA inclusion
- [FEATURE] Add Flexform for Mctest Plugin
- [FEATURE] Rework ext_localconf and ext_tables.php

## [dev-2.0.0-0]
- [FEATURE] Change icons to WACON Logo

## [1.0.0] - 2024-03-31

### Features
- First release of EXT:mctest
