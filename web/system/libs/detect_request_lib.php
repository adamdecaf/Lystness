<?php
/**
 * Lystness
 * Adam Shannon
 */

class DetectRequest {

	/**
	 * Detect some basic details about the request.
	 */
	static function run() {
		$details = array();
		
		// By default we are grabbing data, not sending it.
		$details['submit'] = false;
		
		// Find out if the request is a GET or POST
		if (!empty($_POST)) {
			$details['method'] = 'post';
			$details['submit'] = true;
		} else {
			if (!empty($_GET)) {
				$details['method'] = 'get';
			} else {
				$details['method'] = 'unknown';
			}
		}
		
		// Find out what page was requested
		switch (true) {
			// Page Requests
			case array_key_exists('contact', $_GET):
				$details['page'] = 'contact';
			break;
			
			case array_key_exists('legal', $_GET):
				$details['page'] = 'legal';
			break;
			
			case array_key_exists('tag', $_GET):
				$details['page'] = 'tag';
			break;
			
			case array_key_exists('tour', $_GET):
				$details['page'] = 'tour';
			break;
			
			// Data Pushes
			case array_key_exists('contact_submit', $_GET):
				$details['page'] = 'contact_submit';
				$details['submit'] = true;
			break;
			
			case array_key_exists('item_submit', $_GET):
				$details['page'] = 'item_submit';
				$details['submit'] = true;
			break;
			
			case array_key_exists('register_submit', $_GET):
				$details['page'] = 'register_submit';
				$details['submit'] = true;
			break;
			
			case array_key_exists('tag_submit', $_GET):
				$details['page'] = 'tag_submit';
				$details['submit'] = true;
			break;
			
			// POST requets
			case array_key_exists('register', $_POST):
				$details['page'] = 'register';
			break;
			
			case array_key_exists('login', $_POST):
				$details['page'] = 'login';
			break;
			
			// Show an page on errors.
			default:
				$details['page'] = 'error';
			break;
		}
		
		return $details;
	}

}
