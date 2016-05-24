<?php
	
require_once __DIR__ . '/../common.inc.php';

use Battis\AppMetadata;
use Battis\HierarchicalSimpleCache;

if (file_exists(__DIR__ . '/manifest.xml')) {
	$manifest = simplexml_load_string(file_get_contents(__DIR__ . '/manifest.xml'));
}
$pluginMetadata = new AppMetadata($sql, (string) $manifest->id);
$cache = new HierarchicalSimpleCache($sql, basename(__DIR__));


// FIXME this should be a configurable option, of course
$pluginMetadata['PLACEHOLDER_USER_ID'] = 4229;