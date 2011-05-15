<?php
/**
 * Lystness
 * Adam Shannon
 */
 
$_email = $_POST['email'];
$_password = $_POST['password'];
$_password2 = $_POST['password2'];

if ($_password !== $_password2) {
	exit(REGISTER_PASSWORDS_NOT_MATCH);
}

// Create a user now.
Action::createUser($_email, $password, '-5', '0');
header('Location: index.php');
exit();
