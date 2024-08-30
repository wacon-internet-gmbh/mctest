CREATE TABLE tx_simplequiz_domain_model_quizsessions (
	session_key varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_simplequiz_domain_model_answerreport (
	id varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_simplequiz_domain_model_quiz (
	name varchar(255) NOT NULL DEFAULT '',
	number_of_questions int(11) NOT NULL DEFAULT '0'
);

CREATE TABLE tx_simplequiz_domain_model_answer (
	answer text NOT NULL DEFAULT '',
	is_question_true smallint(1) unsigned NOT NULL DEFAULT '0',
	further_information text NOT NULL DEFAULT ''
);

CREATE TABLE tx_simplequiz_domain_model_question (
	text text NOT NULL DEFAULT '',
	right_answer varchar(255) DEFAULT '' NOT NULL
);

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
