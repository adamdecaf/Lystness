<?php
/**
 * Lystness
 * Adam Shannon
 */
 
$id = Action::getIdWithEmail($_POST['email']);
if (Action::checkPassword($id, $_POST['password'])) {
	Action::createCookieWithId($id);
}

header("Location: index.php");
exit();
