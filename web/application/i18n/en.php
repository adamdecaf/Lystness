<?php
/**
 * Lystness
 * Adam Shannon
 */

// Some global messages 
define('SITE_TITLE', 'Lystness -- The best todo list');
define('WEB_ACCESS_DENIED', 'We\'re sorry, but web access to the site is currently disabled.');

// Errors
define('ERROR_404_TITLE', '404 - Page Not Found');
define('ERROR_404_DESC', 'Whoops, it looks like the page you are trying to view does not exist. Have we broken something? <a href="index.php?contact">Tell us about it!</a>');

// Nav Elements
define('NAV_TOUR', 'Tour');
define('NAV_CONTACT', 'Contact');
define('NAV_LEGAL', 'Legal');
define('NAV_LOGOUT', 'Logout');

// Footer
define('FOOTER_COPYRIGHT', 'Copyright &copy; 2011 -- Adam Shannon -- All Rights Reserved');

// home-guest.html
define('HOME_GUEST_TITLE', 'Welcome to Lystness!');
define('HOME_GUEST_DESC', 'Lystness is a todo application. It provides a service that is both easy to use and provides the needed features for you to get things done.');

// Login
define('LOGIN_EMAIL', 'Your Email: ');
define('LOGIN_PASSWORD', 'Your Password: ');
define('LOGIN_SUBMIT', 'Login');

// Registering
define('REGISTER_TITLE', 'Register');
define('REGISTER_DESC', 'It looks like you haven\'t registered yet. It\'s <em>free</em> and takes <em>one</em> step, why not try it?');
	define('REGISTER_EMAIL', 'Your Email: ');
	define('REGISTER_PASSWORD', 'Your Password: ');
	define('REGISTER_PASSWORD_VERIFY', 'Verify Password: ');
	define('REGISTER_TIMEZONE', 'Your Timezone: ');
	define('REGISTER_SUBMIT', 'Register');
	
// Registration Errors
define('REGISTER_PASSWORDS_NOT_MATCH', 'Whoops, it looks like your passwords don\'t match.');
	define('REGISTER_EMAIL_EXISTS', 'Sorry, but that email is already in use.');
	
// Default titles for tags and items
define('DEFAULT_TAG_NAME', 'My List');
define('DEFAULT_ITEM_NAME', 'My todo list');

// Home page (logged in)
define('HOME_TITLE', 'Your List');
define('HOME_TAGS', 'Tags');
define('HOME_NO_ITEMS', 'Sorry, there are no items to display.');
define('HOME_CREATE_TAG', 'Create Tag');
define('HOME_CREATE_ITEM', 'Create Item');
