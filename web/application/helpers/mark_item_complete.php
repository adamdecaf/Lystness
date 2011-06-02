<?php
/**
 * Lystness
 * Adam Shannon
 */
 
$_user = MySQL::clean($user['user_id']);
$_item = MySQL::clean($_GET['item']);

Action::markItemComplete($_user, $_item);
