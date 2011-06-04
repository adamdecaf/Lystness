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
define('REGISTER_WELCOME_EMAIL', "Welcome to Lystness. If you have any questions or concerns please contact us at: adam@lystness.com");
define('REGISTER_WELCOME_SUBJECT', 'Thanks for registering with Lystness!');
	
// Default titles for tags and items
define('DEFAULT_TAG_NAME', 'My List');
define('DEFAULT_ITEM_NAME', 'My todo list');

// Home page (logged in)
define('HOME_TITLE', 'Your List');
define('HOME_TAGS', 'Tags');
define('HOME_NO_ITEMS', 'Sorry, there are no items to display.');
define('HOME_CREATE_TAG', 'Create Tag');
define('HOME_CREATE_ITEM', 'Create Item');
define('HOME_MARK_AS_DONE', 'Mark as Done');
define('HOME_FOREVER', 'Forever');
define('HOME_DUE', 'Due: ');
define('HOME_DUE_FOREVER', 'In a long time');

// Tags
define('TAG_ADMINS', 'Tag Admins');
define('TAG_MEMBERS', 'Tag Members');
define('TAG_ADD_ADMIN_BUTTON', 'Add Admin');
define('TAG_ADD_MEMBER_BUTTON', 'Add Member');

// Contact
define('CONTACT_TITLE', 'Contact Us');
define('CONTACT_DESC', 'Feel free to send any comments, questions, concerns, errors, or anything to us at: <a href="mailto:adam@lystness.com"><strong>adam [at] lystness.com</strong></a>');

// Legal
define('LEGAL_TITLE', 'Legal Information');
define('LEGAL_PRETEXT', 'This site is designed with the ideas and attitudes of you, the user, in our vision. We are trying to make this site the way you want, and if there&quot;s anything we can do which will perform that, please let us know. <a href="mailto:adam@lystness.com">adam [at] lystness.com</a>');
define('LEGAL_GOALS_DESC', 'Our Goals');

define('LEGAL_GOAL_1', 'Your Data is Your Data');
	define('LEGAL_DESC_1', 'Any data (text, events, etc..) that you send to us is your data. You are (if legally true) the owner and maintainer of that. Yes, we will keep backups of the data, but that is for restoration in the event of a failure. If you submit anything that is not yours, it is your fault and responsibility.');
	
define('LEGAL_GOAL_2', 'Other People Have Rights');
	define('LEGAL_DESC_2', 'Creating tags and adding people only to annoy, spam, or harass them is strictly forbidden. Doing so will result in the loss of your account and possible civil suit by the people you annoy.');
	
define('LEGAL_GOAL_3', 'We Respect Your Rights');
	define('LEGAL_DESC_3', 'Lystness will do whatever it can to protect you. We like you and want to keep you. If we recieve legal threats we will do our best to protect you and your data.');
	
define('LEGAL_GOAL_4', 'You Agree to This and it May Change');
	define('LEGAL_DESC_4', 'By Creating an account you agree to these terms and their possible outcomings. Also, these terms can be modified (in full or part) without your knowledge or concent. (However, doing so without notifying you would be annoying, so we will let you know.)');
	
// Tour
define('TOUR_TITLE', 'A Simple Tour');
define('TOUR_INTRO', 'This site may look scary, sorry about that. It really is a nice site that doesn\'t bite or anything. However, it is different than most todo list applications, but it\'s pretty neat. :)');

define('TOUR_DESC', 'What is Lystness?');
define('TOUR_DESC_DESC', 'Lystness is a todo application which is designed for both group and personal item tracking. You create items and assign them to tags, of which you can share a tag with people to allow them to see and edit items on that tag. Beyond that there really isn\'t anything more complicated.');

define('TOUR_REGISTER', 'Creating an Account');
define('TOUR_REGISTER_DESC', 'In order to keep track of your things, you will need to create an account. Lucky for you it\'s completely free and quite painless! All you need to do is fill out the form on your bottom left and, that\'s it!');

define('TOUR_ITEM', 'Remember Something Todo');
define('TOUR_ITEM_DESC', 'Alright, so you just created an account. Good. You see an item there showing you what items look like, but you have something to remember. Maybe it\'s to get food tonight, or that interview tomorrow. Go ahead and type it into the box, fill out the dropdown menus and click "Create Item"! Your item will be saved and shown to you.');

define('TOUR_TAG', 'Organize Your Things');
define('TOUR_TAG_DESC', 'You seem like someone who does a lot. Perhaps you would like to use tags to organize your thoughts. Go ahead and below "My List" type something in and press "Create Tag". Now when you create items you can organize them into that tag. Pretty simple, huh?');
