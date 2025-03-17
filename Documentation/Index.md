# Simple Quiz Documentation
## Installation
### 1a. TYPO3 Legacy
  1. Go to https://extensions.typo3.org/extension/simplequiz
  2. Download the latest version for your TYPO3 installation
  3. Rename downloaded zip package in: simplequiz.zip
  4. Login into your TYPO3 Backend
  5. Go to the extension manager
  6. Upload ZIP Package
  7. Activate extension

### 1b. TYPO3 Composer
1. ``composer req wacon/simplequiz``

### 2. DB Analyzer
Execute the DB Analyzer inisde the Admin Tools -> Maintenance module

### 3. Configure extension
1. Create a folder with a name of your choice, for example: Simple Quiz
2. Add the TypoScript static file from Simple Quiz to your TypoSript records (for instance of your root page)
3. Create your first quiz in your created folder in step 1 with the list module
4. Add the Simple Quiz frontend plugin on your chosen page
   1. Choose the quiz you have just created
   2. Select the amount of maximum question you want the user to answer
      1. Questions are randomly selected of the amount of created once
   3. Choose quiz type
      1. Single choice (radios)
      2. Multiple choice (checkboxes)

### Routes
Example route configuration for config.yaml of your site configuration can be found [here](Routes.md).
