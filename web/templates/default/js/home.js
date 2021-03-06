/**
 * Lystness
 * Adam Shannon
 * http://lystness.com
 */
 
function get_xhr() {
	if (window.XMLHttpRequest !== undefined) {
		return new XMLHttpRequest();
	}
	return  new ActiveXObject("Microsoft.XMLHTTP");
}

function send_new_item() {
	var 
		desc = encodeURIComponent(document.querySelector('#new-desc').value),
		deadline = encodeURIComponent(document.querySelector('#new-deadline').value),
		tag = encodeURIComponent(document.querySelector('#new-tag').value);
	var xhr = get_xhr();
	
	xhr.open('GET', 'index.php?new_item=true&desc=' + desc + '&deadline=' + deadline + '&tag=' + tag, false);
	xhr.send(null);
	
	window.location.reload();
}

function send_new_tag() {
	var title = encodeURIComponent(document.querySelector('#new-title').value);
	var xhr = get_xhr();
	
	xhr.open('GET', 'index.php?new_tag=true&title=' + title, false);
	xhr.send(null);
	
	window.location.reload();
}

function mark_as_done(item_id) {
	var id = encodeURIComponent(item_id);
	var xhr = get_xhr();
	
	xhr.open('GET', 'index.php?mark_item_complete=true&item=' + id, false);
	xhr.send(null);
	//alert(xhr.responseText);
	
	window.location.reload();
	
}

function add_admin() {
	var xhr = get_xhr();
	var user = encodeURIComponent(document.querySelector('#new-admin').value);
	var tag = encodeURIComponent(document.querySelector('#tag').value);
	
	xhr.open('GET', 'index.php?add_admin_to_tag=true&user_id=' + user + '&tag=' + tag, false);
	xhr.send(null);
	
	window.location.reload();
}

function add_member() {
	var xhr = get_xhr();
	var user = encodeURIComponent(document.querySelector('#new-member').value);
	var tag = encodeURIComponent(document.querySelector('#tag').value);
	
	xhr.open('GET', 'index.php?add_member_to_tag=true&user_id=' + user + '&tag=' + tag, false);
	xhr.send(null);
	
	window.location.reload();
}

function delete_tag(tag) {
	var _t = encodeURIComponent(tag);
	var xhr = get_xhr();
	
	xhr.open('GET', 'index.php?delete_tag=true&tag=' + _t, false);
	xhr.send();
	
	window.location.reload();
}
