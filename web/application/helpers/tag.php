<?php
/**
 * Lystness
 * Adam Shannon
 */
 
$_tag = MySQL::clean($_GET['tag']);
$members = Action::getMembersOfTag($_tag);
$admins = Action::getAdminsOfTag($_tag);

function print_admins_of_tag($admins) {
	foreach ($admins as $admin) {
		print '<li>' . Action::getEmailWithId($admin['user_id']) . '</li>';
	}
}

function print_members_of_tag($members) {
	foreach ($members as $member) {
		print '<li>' . Action::getEmailWithId($member['user_id']) . '</li>';
	}
}

function print_add_admin_form($id, $tag) {
	if (Action::authTagChange($id, $tag)) {
		echo "<input type='text' id='new-admin' />";
		echo "<input type='button' value='" . TAG_ADD_ADMIN_BUTTON . "' onclick='add_admin();' />";
	}
}

function print_add_member_form($id, $tag) {
	if (Action::authTagChange($id, $tag)) {
		echo "<input type='text' id='new-member' />";
		echo "<input type='button' value='" . TAG_ADD_MEMBER_BUTTON . "' onclick='add_member();' />";
	}
}
