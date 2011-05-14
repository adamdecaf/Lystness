<?php
/**
 * Lystness
 * Adam Shannon
 */

// Load and process the config settings.
require 'application/config/config.php';
	
	// Load the i18n file.
	// For now this will be hard coded, but a valuable user setting later on.
	// Also, the DB has a location for some INT(4) value which should be used as the index for some
	// array of i18n files.
	require 'application/i18n/' . $config['i18n'] . '.php';

	// Make sure that web access to the site is enabled.	
	if ($config['web'] !== 'enabled') {
		exit(WEB_ACCESS_DENIED);
	}
	
	// Connect to the MySQL database.
	require 'system/libs/mysql.class.php';
	MySQL::set_vars(
		$config['mysql']['hostname'], 
		$config['mysql']['username'],
		$config['mysql']['password']
	);
	MySQL::$db = $config['mysql']['database'];
	
// Load some common libraries
require 'system/libs/actions.php';
	
	// Figure out what type of user we are dealing with.
	$user = Action::detectUser();
		//print_r($user);
	
// Find out what type of request we are dealing with.
require 'system/libs/detect_request_lib.php';
$request = DetectRequest::run();
	//print_r($request);
	
	// Load the header.
	if ($request['method'] !== 'post') {
		include 'templates/' . $config['template'] . '/html/header.html';
	}
	
	// Load the specific page requested.
	if ($request['method'] == 'unknown') {
		// Load up the home page.
		include 'application/helpers/home.php';
		include 'templates/' . $config['template'] . '/html/home.html';
	} else {
		// Load up the specific page.
		include 'application/helpers/' . $request['page'] . '.php';
		
		// Only load the template page if needed
		// ['submit'] = true, for requests that send data to the server.
		if ($request['submit'] != true) {
			include 'templates/' . $config['template'] . '/html/' . $request['page'] . '.html';
		}
	}
	
	// Don't forget the footer!
	if ($request['method'] !== 'post') {
		include 'templates/' . $config['template'] . '/html/footer.html';
	}
