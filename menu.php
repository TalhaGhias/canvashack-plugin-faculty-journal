<?php

require_once __DIR__ . '/common.inc.php';

use Battis\BootstrapSmarty\BootstrapSmarty;

$smarty = BootstrapSmarty::getSmarty();
$smarty->addTemplateDir(__DIR__ . '/templates');
$smarty->addStylesheet('css/menu.css', basename(__FILE__));

$smarty->assign('canvasInstance', $_SESSION['canvasInstanceUrl']);
$smarty->assign('pluginUrl', $pluginMetadata['PLUGIN_URL']);
$smarty->assign('user', $_REQUEST['user_id']);
$smarty->assign('course', $_REQUEST['course_id']);
$smarty->assign('name', $_REQUEST['course_name']);

$smarty->display(basename(__FILE__, '.php') . '.tpl');