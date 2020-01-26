<?php

require_once __DIR__ . '/common.inc.php';

use Battis\BootstrapSmarty\BootstrapSmarty;

$smarty = BootstrapSmarty::getSmarty();
$smarty->addTemplateDir(__DIR__ . '/templates');
$smarty->addStylesheet('css/menu.css', basename(__FILE__));
echo 'here';
$smarty->assign([
    'canvasInstance' => $_SESSION['canvasInstanceUrl'],
    'pluginUrl' => $pluginMetadata['PLUGIN_URL'],
    'user' => $_REQUEST['user_id'],
    'course' => $_REQUEST['course_id'],
    'name' => $_REQUEST['course_name']
]);

$smarty->display(basename(__FILE__, '.php') . '.tpl');
