<?php
/**
 * Lystness
 * Adam Shannon
 */
 
$_tag = MySQL::clean($_GET['tag']);

if (Action::authTagChange($user['user_id'], $_tag)) {
	Action::deleteTag($user['user_id'], $_tag);
}
