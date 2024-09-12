# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
- [FEATURE] Add Flexform for Simplequiz Plugin
- [FEATURE] Rework ext_localconf and ext_tables.php

## [dev-2.0.0-0]
- [FEATURE] Change icons to WACON Logo

## [1.0.0] - 2024-03-31

### Features
- First release of EXT:simplequiz
