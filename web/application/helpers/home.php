<?php
/**
 * Lystness
 * Adam Shannon
 */

$tags = Action::getTags($user['user_id']);
$items = Action::getItems($user['user_id'], $tags);

function print_tags($tags) {
	foreach ($tags as $tag) {
		echo "<li><a href='index.php?tag={$tag['tag_id']}'>{$tag['title']}</a></li>";
	}
}

function print_items($items) {
	foreach ($items as $item) {
		echo '<li><span>';
			echo $item['desc'] . ' -- <a href="index.php?tag=' . $item['tag'] . '">' . $item['tag-desc'] . '</a><br />';
			echo 'Completed: ';
				echo ($item['completed'] == '1') ? 'yes' : 'no';
			echo ' -- Due: ' . $item['deadline'];
		echo '</span></li>';
	}	
}

