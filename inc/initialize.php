<?php

// Define core paths.

// DIRECTORY_SEPARATOR.
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

// Site root.
defined('SITE_ROOT') ? null :
 define('SITE_ROOT', DS.'Users'.DS.'Mike'.DS.'Development'.DS.'php'.DS.'php-photo-gallery');

// Lib path.
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'inc');

// Load config first.
require_once(LIB_PATH.DS.'config.php');

// Load basic functions.
require_once(LIB_PATH.DS.'functions.php');

// Load core objects.
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'database.php');

// Load other class.
require_once(LIB_PATH.DS.'user.php');
require_once(LIB_PATH.DS.'photograph.php');
?>