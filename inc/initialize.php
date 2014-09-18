<?php

// Define core paths.

// DIRECTORY_SEPARATOR.
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

// Site root.
//defined('SITE_ROOT') ? null : define('SITE_ROOT', '');

// Lib path.
//defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'inc');

// Load config first.
require_once('config.php');

// Load basic functions.
require_once('functions.php');

// Load core objects.
require_once('session.php');
require_once('database.php');

// Load user class.
require_once('user.php');
?>