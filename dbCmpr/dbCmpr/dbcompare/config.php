<?php

/**
 * This file should contain the configuration of databases.
 *
 * $dbs_config is an array of database configurations. Each element of the
 * array should provide details for a database which will be selectable from
 * a list.
 *
 * This is arguably more secure and convenient than submitting database
 * details with an HTML form (and sending them over an unsecured channel).
 *
 * Refer to the 'Demo Configuration' below for reference.
 */

$dbs_config = array(
	 array(
	 	'name' => 'Demo Configuration',
	 	'config' => array(
	 		'host'		=> 'localhost',
	 		'user'		=> 'root',
	 		'password'	=> '',
	 		'name'		=> 'kristero_db'
	 	)
	 ),
);


define( '__CONGRATS__' , 'Congratulations, No difference found.' );
define( '__MAIN_PAGE__' , '<p><a href="?">&laquo; Back to main page</a></p>' );