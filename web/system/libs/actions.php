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
		$_id = MySQL::clean($user_id);
		$_tag = MySQL::clean($tag_id);
		$admins = MySQL::single("SELECT `tag_id` FROM `". MySQL::$db . "`.`admin-tags` WHERE `user_id` = '{$_id}' AND `tag_id` = '{$_tag}' LIMIT 1;");
		
		if (!empty($admins) && $admins['tag_id'] == $_tag) {
			return true;
		}
		return false;
	}

	/**
	 * createCookie($user_id)
	 *
	 */
	static function createCookie($cookie) {
		setcookie('user', $cookie, @time()+60*60*24*30);
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
		
		// Create a cookie for the user
		self::createCookie($_cookie);
		
		// Send them a welcome email
		self::sendEmail($id, REGISTER_WELCOME_SUBJECT, REGISTER_WELCOME_EMAIL);
	}
	
	/**
	 * sendEmail($user, $msg)
	 */
	static function sendEmail($user, $subject, $msg) {
		$_id = MySQL::clean($user);
		$_sub = MySQL::clean(htmlentities(substr($subject, 0, 150)));
		$_msg = MySQL::clean(htmlentities(substr($msg, 0, 1000)));
		$email = self::getEmailWithId($_id);
		
		mail($email, $_sub, $_msg, 'FROM: adam@lystness.com');
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
		
		// Insert the tag into `tag`
		$sql = "INSERT INTO `". MySQL::$db . "`.`tags` (`id`,`title`, `author`,`count`) VALUES ";
		$sql .= "('0','" . DEFAULT_TAG_NAME . "', '{$_id}','0');";	
		MySQL::query($sql);
		
		// Pull the newly created tag's id
		$sql = "SELECT `id` FROM `". MySQL::$db . "`.`tags` WHERE `author` = '{$_id}' ORDER BY `id` DESC LIMIT 1;";
		$latest = MySQL::single($sql);
		
		// Use that to create the reference for visibility
		$sql = "INSERT INTO `". MySQL::$db . "`.`user-tags` (`user_id`,`tag_id`) VALUES ('{$_id}', '{$latest['id']}');";
		MySQL::query($sql);
		
		// and for adminship.
		$sql = "INSERT INTO `". MySQL::$db . "`.`admin-tags` (`user_id`,`tag_id`) VALUES ('{$_id}', '{$latest['id']}');";
		MySQL::query($sql);
		
		return $latest['id'];
	}
	
	/**
	 * createTag($user_id, $title)
	 */
	static function createTag($user_id, $title) {
		$_id = MySQL::clean($user_id);
		$_title = MySQL::clean(substr($title, 0, 30));
	
		$sql = "INSERT INTO `". MySQL::$db . "`.`tags` (`id`,`title`, `author`,`count`) VALUES ";
		$sql .= "('0','{$_title}', '{$_id}','0');";	
		MySQL::query($sql);
		
		// Pull the newly created tag's id
		$sql = "SELECT `id` FROM `". MySQL::$db . "`.`tags` WHERE `author` = '{$_id}' ORDER BY `id` DESC LIMIT 1;";
		$latest = MySQL::single($sql);
		
		// Use that to create the reference for visibility
		$sql = "INSERT INTO `". MySQL::$db . "`.`user-tags` (`user_id`,`tag_id`) VALUES ('{$_id}', '{$latest['id']}');";
		MySQL::query($sql);
		
		// and for adminship.
		$sql = "INSERT INTO `". MySQL::$db . "`.`admin-tags` (`user_id`,`tag_id`) VALUES ('{$_id}', '{$latest['id']}');";
		MySQL::query($sql);
	}
	
	/**
	 * addUserToTag($user, $tag)
	 */
	static function addUserToTag($user, $tag) {
		$_u = MySQL::clean($user);
		$_t = MySQL::clean($tag);
		
		$sql = "INSERT INTO `" . MySQL::$db . "`.`user-tags` (`user_id`,`tag_id`) VALUES ('{$_u}','{$_t}')";
		MySQL::query($sql);
	}
	
	/**
	 * addAdminToTag($user, $tag)
	 */
	static function addAdminToTag($user, $tag) {
		$_u = MySQL::clean($user);
		$_t = MySQL::clean($tag);
		
		$sql = "INSERT INTO `" . MySQL::$db . "`.`admin-tags` (`user_id`,`tag_id`) VALUES ('{$_u}','{$_t}')";
		MySQL::query($sql);
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
	 * createItem($user_id, $desc, $deadline, $tag)
	 */
	static function createItem($user_id, $desc, $deadline, $tag) {
		$_id = MySQL::clean($user_id);
		$_desc = MySQL::clean(substr($desc, 0, 150));
		$_deadline = MySQL::clean($deadline);
		$_tag = MySQL::clean($tag);
		
		if (self::authTagChange($_id, $_tag)) {
			$sql = "INSERT INTO `" . MySQL::$db . "`.`items` (`id`,`tag`,`description`,`deadline`,`completed`) VALUES ";
			$sql .= "('0','{$_tag}','{$_desc}','{$deadline}','0');";
			MySQL::query($sql);
		}
		
		// TODO: Increment the tag's `count` value.
	}
	
	/**
	 * getItems($user_id)
	 * Return an array of the items for a user that are still due.
	 */
	static function getItems($user_id, $tags) {
		$_id = MySQL::clean($user_id);
		$now = @time() - 86400;
		$items = array();
		
		foreach ($tags as $tag) {
			$_tmp = MySQL::search("SELECT * FROM `" . MySQL::$db . "`.`items` WHERE `tag` = '{$tag['tag_id']}' AND `deadline` > '{$now}' AND `completed` != '1' ORDER BY `deadline` ASC;");
			foreach ($_tmp as $_a) {
				array_push($items, array(
					'id' => $_a['id'],
					'tag' => $_a['tag'],
					'tag-desc' => self::getTagTitle($tag['tag_id']),
					'desc' => $_a['description'],
					'deadline' => $_a['deadline'],
					'completed' => $_a['completed'],
				));
			}
		}
		
		// We need a special nested function to compare
		function cmp($a, $b) {
			return ($a['deadline'] > $b['deadline']) ? 1 : -1;
		}
		
		$item = usort($items, "cmp");
		return $items;
	}
	
	/**
	 * getTags($user_id)
	 * Return an array of the tags that are visible to a user.
	 */
	static function getTags($user_id) {
		$_id = MySQL::clean($user_id);
		$tags = array();
		
		$sql = "SELECT `tag_id` FROM `" . MySQL::$db . "`.`user-tags` WHERE `user_id` = '{$_id}';";
		$_tags = MySQL::search($sql);
		
		foreach ($_tags as $tag) {
			$_tmp = MySQL::single("SELECT `title` FROM `" . MySQL::$db . "`.`tags` WHERE `id` = '{$tag['tag_id']}' LIMIT 1");
			$tags[] = array(
				'tag_id' => $tag['tag_id'],
				'title' => $_tmp['title']
			);
		}
		
		return $tags;
	}
	
	/**
	 * getTagTitle($tag_id)
	 * Return the tag's title
	 */
	static function getTagTitle($tag_id) {
		$_id = MySQL::clean($tag_id);
		$_tmp = MySQL::single("SELECT `title` FROM `" . MySQL::$db . "`.`tags` WHERE `id` = '{$_id}' LIMIT 1");
		return $_tmp['title'];
	}
	
	/**
	 * getItemTag($item)
	 */
	static function getItemTag($item) {
		$_item = MySQL::clean($item);
		$tmp = MySQL::single("SELECT `tag` FROM `" . MySQL::$db . "`.`items` WHERE `id` = '{$_item}' LIMIT 1;");
		return $tmp['tag'];
	}
	
	/** 
	 * markItemComplete($user_id, $item_id)
	 */
	static function markItemComplete($user_id, $item_id) {
		$_id = MySQL::clean($user_id);
		$_item = MySQL::clean($item_id);
		$tags = self::getTags($_id);
		$_tag = self::getItemTag($_item);
		
		foreach ($tags as $tag) {
			if (in_array($_tag, $tag)) {
				$sql = "UPDATE `" . MySQL::$db . "`.`items` SET  `completed` =  '1' WHERE  `items`.`id` = '" . $_item . "';";
				MySQL::query($sql);
				exit();
			}
		}
	}
	
	/**
	 * getMembersOfTag($tag)
	 */
	static function getMembersOfTag($tag) {
		$_tag = MySQL::clean($tag);
		$members = MySQL::search("SELECT `user_id` FROM `" . MySQL::$db . "`.`user-tags` WHERE `tag_id` = '{$_tag}' LIMIT 1000;");
		return $members;
	}
	
	/**
	 * getAdminsOfTag($tag)
	 */
	static function getAdminsOfTag($tag) {
		$_tag = MySQL::clean($tag);
		$admins = MySQL::search("SELECT `user_id` FROM `" . MySQL::$db . "`.`admin-tags` WHERE `tag_id` = '{$_tag}' LIMIT 1000;");
		return $admins;
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
