<?php
/**
 * Lystness
 * Adam Shannon
 */
 
$users = MySQL::single("SELECT COUNT(`id`) FROM `" . MySQL::$db . "`.`users`");
$items = MySQL::single("SELECT COUNT(`id`) FROM `". MySQL::$db . "`.`items`");
$tags = MySQL::single("SELECT COUNT(`id`) FROM `" . MYSQL::$db . "`.`tags`");
