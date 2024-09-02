CREATE TABLE tx_simplequiz_domain_model_quizsessions (
	data varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_simplequiz_domain_model_quiz (
	name varchar(255) NOT NULL DEFAULT '',
	questions varchar(255) DEFAULT '' NOT NULL
);

CREATE TABLE tx_simplequiz_domain_model_answer (
	answer text NOT NULL DEFAULT '',
	is_correct smallint(1) unsigned NOT NULL DEFAULT '0',
	further_information text NOT NULL DEFAULT ''
);

CREATE TABLE tx_simplequiz_domain_model_question (
	question text NOT NULL DEFAULT '',
	answers varchar(255) DEFAULT '' NOT NULL
);

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
