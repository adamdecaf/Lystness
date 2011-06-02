<?php
/**
 * Lystness
 * Adam Shannon
 */

$tags = Action::getTags($user['user_id']);
$items = Action::getItems($user['user_id'], $tags);

function print_tags($tags) {
	foreach ($tags as $tag) {
		echo "<li><a href='index.php?tag={$tag['tag_id']}'>{$tag['title']}</a>";
		echo " <span style='cursor:pointer;' onclick='delete_tag({$tag['tag_id']});'>[x]</span></li>";
	}
}

function print_items($items) {
	if (count($items) < 1) {
		echo HOME_NO_ITEMS;
	} else {
		foreach ($items as $item) {
			echo '<li><span>';
				echo stripslashes($item['desc']) . ' -- <a href="index.php?tag=' . $item['tag'] . '">' . $item['tag-desc'] . '</a><br />';
					//echo 'Completed: ' . ($item['completed'] == '1') ? 'yes' : 'no';
				echo "<a href='#' onclick='mark_as_done({$item['id']});'>" . HOME_MARK_AS_DONE . "</a>";
				if ($item['deadline'] == 2000000000) {
					echo ' -- ' . HOME_DUE . HOME_DUE_FOREVER;
				} else {
					echo ' -- ' . HOME_DUE . @date('m/d', $item['deadline']);
				}
			echo '</span></li>';
		}	
	}
}

function print_deadline_items() {
	$now = @time();
	$day = @date('m/d', $now);
	
		echo "<option value='2000000000'>" . HOME_FOREVER . "</option>";
	for ($i = 0; $i < 30; $i++) {
		echo "<option value='{$now}'>{$day}</option>";
		$now += 86400;
		$day = @date('m/d', $now);
	}
}

function print_tag_items($tags) {
	foreach ($tags as $tag) {
		echo "<option value='{$tag['tag_id']}'>{$tag['title']}</option>";
	}
}
