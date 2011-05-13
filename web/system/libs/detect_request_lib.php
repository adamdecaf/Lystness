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
		
		// Find out if the request is a GET or POST
		if (!empty($_GET)) {
			$details['method'] = 'get';
		} else {
			if (!empty($_POST)) {
				$details['method'] = 'post';
			} else {
				$details['method'] = 'unknown';
			}
		}
		
		// Find out what page was requested
		switch (true) {
			case array_key_exists('contact', $_GET):
				$details['page'] = 'contact';
			break;
			
			case array_key_exists('legal', $_GET):
				$details['page'] = 'legal';
			break;
			
			case array_key_exists('register', $_GET):
				$details['page'] = 'register';
			break;
			
			case array_key_exists('tag', $_GET):
				$details['page'] = 'tag';
			break;
			
			case array_key_exists('tour', $_GET):
				$details['page'] = 'tour';
			break;
		}
		
		return $details;
	}

}
