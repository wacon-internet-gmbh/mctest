CREATE TABLE tx_simplequiz_domain_model_quizsession (
	quiz INT(11) DEFAULT '0' NOT NULL,
	name varchar(255) NOT NULL DEFAULT '',
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
