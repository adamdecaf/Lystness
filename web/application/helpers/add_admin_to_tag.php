<?php
/**
 * Lystness
 * Adam Shannon
 */
 
$_id = MySQL::clean(Action::getIdWithEmail($_GET['user_id']));
$_tag = MySQL::clean($_GET['tag']);

if (Action::authTagChange($user['user_id'], $_tag) && $_id != '') {
	Action::addAdminToTag($_id, $_tag);
}
