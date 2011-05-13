<?php
/**
 * Lystness
 * Adam Shannon
 */

// Load and process the config settings.
require 'application/config/config.php';

	// Make sure that web access to the site is enabled.
	if ($config['web'] !== 'enabled']) {
		exit(WEB_ACCESS_DENIED);
	}
	
	// Load the i18n file.
	// For now this will be hard coded, but a valuable user setting later on.
	// Also, the DB has a location for some INT(4) value which should be used as the index for some
	// array of i18n files.
	require 'application/i18n/' . $config['i18n'] . '.php';
