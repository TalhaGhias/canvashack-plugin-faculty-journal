<?php

header("Content-type: text/javascript");

require_once __DIR__ . '/../common.inc.php';

$cache->pushKey($_REQUEST['course_id']);
$html = $cache->getCache('menu');
if ($html === false) {
	$menu = [];
	$sections = $api->get("courses/{$_REQUEST['course_id']}/sections");
	foreach ($sections as $section) {
		$menu[$section['name']] = [];
		$enrollments = $api->get(
			"sections/{$section['id']}/enrollments",
			[
				'type' => ['StudentEnrollment']
			]
		);
		foreach ($enrollments as $enrollment) {
			if ($enrollment['user']['name'] !== 'Test Student') {
				$menu[$section['name']][$enrollment['user']['id']] = addslashes($enrollment['user']['sortable_name']);
			}
		}
	}
	$html = '';
	foreach ($menu as $section => $students) {
		$html .= '<optgroup label="' . $section . '">';
		foreach ($students as $id => $name) {
			$html .= '<option value="' . $id . '"' . ($id == $_REQUEST['user_id'] ? ' selected' : '') . '>' . $name . '</option>';
		}
	}
	$cache->setCache('menu', $html);
}

?>

var faculty_menu_student_loader = {
	go: function() {
		var user = /user_id=(\d+)/.exec(document.location.href)[1];
		$('#placeholder').remove();
		$('#students').append('<?= $html ?>');
		$('[disabled=disabled]').removeAttr('disabled');
		if (user != '<?= $pluginMetadata['PLACEHOLDER_USER_ID'] ?>') {
			$('#students').val(user);
		} else {
			$('#students').val($('#students option:first-child').val());
			$('#students').change();
		}
	}
}
