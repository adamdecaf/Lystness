<?php
/**
 * Lystness
 * Adam Shannon
 */

class Action {

	/**
	 * genSalt($len = 50, $charset = 'a-zA-Z0-9')
	 * Generate a salt, for hashing.
	 */
	static function genSalt($len = 50, $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
		
		$salt = '';
		for ($i = 0; $i < $len; $i++) {
			$salt .= substr($charset, mt_rand(0, strlen($charset)), 1);
		}
		return $salt;
		
	}
	
	/**
	 * genHash($str)
	 * Return the sha1 of a string
	 */
	static function genHash($str) {
		return sha1($str);
	}
	
	/**
	 * getHashWithId($user_id)
	 * Return the 40 character hash given a user id.
	 */
	static function getHashWithId($user_id) {
		$_id = MySQL::clean($user_id);
		$result = MySQL::single("SELECT `password` FROM `" . MySQL::$db . "`.`users` WHERE `id` = '{$_id}' LIMIT 1;");
		return $result['password'];
	}
	
	/**
	 * checkPassword($user_id, $submitted_pass)
	 *
	 */
	static function checkPassword($user_id, $submitted_pass) {
		$_id = MySQL::clean($user_id);
		$_pass = MySQL::clean($submitted_pass);
		$__hash = self::getHashWithId($_id);
		$__salt = MySQL::single("SELECT `salt` FROM `" . MySQL::$db . "`.`users` WHERE `id` = '{$_id}' LIMIT 1;");
		
		echo $_pass . $__salt['salt'] . '<br />';
		//echo '-' . self::genHash($_pass . $__salt['salt']) . '- -- -' . $__hash . '-<br />';
		if (self::genHash($_pass . $__salt['salt']) == $__hash) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * getEmailWithId($user_id)
	 * 
	 */
	static function getEmailWithId($user_id) {
		$_id = MySQL::clean($user_id);
		$email = MySQL::single("SELECT `email` FROM `" . MySQL::$db . "`.`users` WHERE `id` = '{$_id}' LIMIT 1");
		return $email['email'];
	}
	 
	/**
	 * getIdWithEmail($email)
	 * 
	 */
	static function getIdWithEmail($email) {
		$_email = MySQL::clean($email);
		$id = MySQL::single("SELECT `id` FROM `" . MySQL::$db . "`.`users` WHERE `email` = '{$_email}' LIMIT 1");
		return $id['id'];
	}
	
	/**
	 * authTagChange($user_id, $tag_id)
	 * 
	 */
	static function authTagChange($user_id, $tag_id) {
		$_tag = MySQL::clean($tag_id);
		$admins = MySQL::single("SELECT `admin` FROM `" . MySQL::$db . "`.`tags` WHERE `id` = '{$_tag}' LIMIT 1");
		
		$_id = MySQL::clean($user_id);
		if (preg_match("/(,?{$_id},)/i", $admins['admin'])) {
			return true;
		}
		return false;
	}

	/**
	 * createCookie($user_id)
	 *
	 */
	static function createCookie($cookie) {
		setcookie('user', $cookie);
	}
	 
	/**
	 * createCookieWithId($user_id)
	 *
	 */
	static function createCookieWithId($user_id) {
		$_id = MySQL::clean($user_id);
		$sql = "SELECT `cookie` FROM `" . MySQL::$db . "`.`users` WHERE `id` = '{$_id}' LIMIT 1";
		$cookie = MySQL::single($sql);
		self::createCookie($cookie['cookie']);
	}
	 
	/**
	 * deleteCookie($user_id)
	 *
	 */
	static function deleteCookie($user_id) {
		setcookie('user', false);
	}
	
	/**
	 * createUser($email, $submitted_pass, $timezone, $i18n)
	 *
	 */
	static function createUser($email, $submitted_pass, $timezone, $i18n) {
		// Should check for duplicate emails.
		$_salt = self::genSalt();
		$_hash = self::genHash($submitted_pass . $_salt);
		$_email = MySQL::clean($email);
		$_timezone = MySQL::clean($timezone);
		$_i18n = MySQL::clean($i18n);
		$_cookie = self::genSalt(30);
		
		// Check to make sure someone with that email doesn't exist.
		$email_2x = self::getIdWithEmail($_email);
		if (!empty($email_2x)) {
			exit(REGISTER_EMAIL_EXISTS);
		}
		
		$sql = "INSERT INTO `" . MySQL::$db . "`.`users` (`id`,`email`,`password`,`salt`,`timezone`,`i18n`,`cookie`) VALUES ";
		$sql .= "('0','{$_email}','{$_hash}','{$_salt}','{$_timezone}','{$_i18n}','{$_cookie}');";
		MySQL::query($sql);
		
		// Find the user_id
		$id = self::getIdWithEmail($_email);
		// Create a sample tag
		$tag = self::createDefaultTag($id);
		// Create a sample item
		self::createDefaultItem($id, $tag);
		
		self::createCookie($_cookie);
	}
	
	/**
	 * authUser($user_id)
	 *
	 */
	static function authUser($cookie) {
		$auth = array();
		$auth['valid'] = false;
		$auth['id'] = '-1';
		
		$_cookie = MySQL::clean($cookie);
		$sql = "SELECT `id` FROM `" . MySQL::$db . "`.`users` WHERE `cookie` = '{$_cookie}' LIMIT 1";
		$result = MySQL::single($sql);
		
		if (!empty($result)) {
			$auth['valid'] = true;
			$auth['id'] = $result['id'];
		}
		return $auth;
	}
	
	/**
	 * detectUser()
	 *
	 */
	static function detectUser() {
		$details = array();
		$details['is_user'] = false;
		
		if (!empty($_COOKIE) && $_COOKIE['user'] !== '') {
			$auth = self::authUser($_COOKIE['user']);
			if ($auth['valid']) {
				$details['is_user'] = true;
				$details['user_id'] = $auth['id'];
			}
		}
		
		return $details;
	}
	
	/**
	 * createDefaultTag($user_id)
	 */
	static function createDefaultTag($user_id) {
		$_id = MySQL::clean($user_id);
		$sql = "INSERT INTO `". MySQL::$db . "`.`tags` (`id`,`title`,`visible`,`admin`,`count`) VALUES ";
		$sql .= "('0','" . DEFAULT_TAG_NAME . "','{$_id},','{$_id},','0');";	
		MySQL::query($sql);
		
		$sql = "SELECT `id` FROM `" . MySQL::$db . "`.`tags` WHERE `visible` = '{$_id},' AND `admin` = '{$_id},' LIMIT 1";
		$ret = MySQL::single($sql);
		return $ret['id'];
	}
	
	/**
	 * createDefaultItem($user_id, $tag)
	 */
	static function createDefaultItem($user_id, $tag) {
		$_id = MySQL::clean($user_id);
		$_tag = MySQL::clean($tag);
		$week = time() + (86400 * 7);
		$sql = "INSERT INTO `" . MySQL::$db . "`.`items` (`id`,`tag`,`description`,`deadline`,`completed`) VALUES ";
		$sql .= "('0','{$_tag}','" . DEFAULT_ITEM_NAME . "','" . $week . "','0');";
		MySQL::query($sql);
	}
	
	/**
	 * updateEmail($user_id, $new_email)
	 *
	 */
	static function updateEmail($user_id, $new_email) {
	
	} 
	
	/**
	 * updatePassword($user_id, $old_password, $new_password)
	 *
	 */
	static function updatePassword($user_id, $old_password, $new_password) {
		
	}
	
	/**
	 * updateTimezone($user_id, $timezone)
	 *
	 */
	static function updateTimezone($user_id, $timezone) {
	
	}
	
	/**
	 * updateI18n($user_id, $i18n)
	 *
	 */
	static function updateI18n($user_id, $i18n) {
		
	}
	
	/**
	 * printTimezones()
	 */
	static function printTimezones() {
		// Just print a dropdown
		echo '<select name="timezone">';
			foreach (TIMEZONES::$zones as $key => $value) {
				echo '<option value="'. $key . '">' . $value . '</option>';
			}
		echo '</select>';
	}

}
