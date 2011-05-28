/**
 * Lystness
 * Adam Shannon
 * http://lystness.com
 */

function send_new_item() {
	var 
		desc = encodeURIComponent(document.querySelector('#new-desc').value),
		deadline = encodeURIComponent(document.querySelector('#new-deadline').value),
		tag = encodeURIComponent(document.querySelector('#new-tag').value);
		
	if (window.XMLHttpRequest !== undefined) {
		var xhr = new XMLHttpRequest();
	} else {
		var xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xhr.open('GET', 'index.php?new_item=true&desc=' + desc + '&deadline=' + deadline + '&tag=' + tag, false);
	xhr.send(null);
	
	window.location.reload();
}

function send_new_tag() {
	var title = encodeURIComponent(document.querySelector('#new-title').value);
	
	if (window.XMLHttpRequest !== undefined) {
		var xhr = new XMLHttpRequest();
	} else {
		var xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xhr.open('GET', 'index.php?new_tag=true&title=' + title, false);
	xhr.send(null);
	
	window.location.reload();
}
