<?php

define('TOOL_NAME', "Scrollable Faculty Journal");
define('CACHE_DURATION', 21600); // 6 hours

if (!defined('CANVAS_API_URL')) {
	require_once(__DIR__ . '/.ignore.faculty-journal-authentication.inc.php');
}

if (!defined('SMCANVASLIB_PATH')) {
	require_once(__DIR__ . '/smcanvaslib/config.inc.php');
}
?>