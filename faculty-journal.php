<?php

header('Content-Type: application/javascript');

require_once(__DIR__ . '/config.inc.php');
require_once(SMCANVASLIB_PATH . '/include/mysql.inc.php');

if (isset($_REQUEST['user_id'])) {
	if (is_numeric($_REQUEST['user_id'])) {
		$userId = $_REQUEST['user_id'];
	} else {
		$userId = preg_replace('|.*users/(\d+)/?.*|', '$1', $_REQUEST['user_id']);
	}
}

if (!isset($userId) || !strlen($userId)) {
	exit;
}

/* get the current user's preferences */
$response = mysqlQuery("
	SELECT * FROM `users`
		WHERE
			`id` = '" . $userId . "'
");
$userPrefs = $response->fetch_assoc();
$userPrefs['groups'] = unserialize($userPrefs['groups']);

?>
/*jslint browser: true, devel: true, eqeq: true, plusplus: true, sloppy: true, vars: true, white: true */

var courseUsersUrl = /.*\/courses\/(\d+)\/users/;
var facultyJournalUrl = /.*\/users\/(\d+)\/user_notes\?course_id=(\d+)/;
var delay = 250;

function stmarks_addFacultyJournalButton() {
	var rightSideToolbar = document.getElementById('right-side').children[0];
	if (rightSideToolbar !== undefined && document.getElementsByClassName('StudentEnrollment').length > 0) {
		var courseId = courseUsersUrl.exec(document.location.href)[1];
		var userId = document.getElementsByClassName('StudentEnrollment')[0].id.substr(5);
		var facultyJournalLink = document.createElement('a');
		facultyJournalLink.href = '/users/' + userId + '/user_notes?course_id=' + courseId;
		facultyJournalLink.className = 'btn button-sidebar-wide btn-danger';
		facultyJournalLink.innerHTML = 'Faculty Journal';
		rightSideToolbar.appendChild(facultyJournalLink);
	// if the right-side toolbar isn't ready yet, try again soon
	} else {
		window.setTimeout(stmarks_addFacultyJournalButton, 25);
	}
}

function stmarks_addFacultyJournalMenu() {
	var contentDiv = document.getElementById('content');
	if (contentDiv !== undefined) {
		var userId = facultyJournalUrl.exec(document.location.href)[1];
		var courseId = facultyJournalUrl.exec(document.location.href)[2];
		var courseMenu = document.createElement('iframe');
		courseMenu.width = '100%';
		courseMenu.height = '30';
		courseMenu.frameBorder = '0';
		courseMenu.src = '<?= 'https://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']) ?>/menu.php?course_id=' + courseId + '&user_id=' + userId;
		contentDiv.insertBefore(courseMenu, contentDiv.firstChild);
	// if the content area isn't ready yet, try again soon
	} else {
		window.setTimeout(stmarks_addFacultyJournalMenu, 25);
	}
}

function stmarks_facultyJournal() {
	// FIXME: this should have some sort of authentication or hash check to prevent, um... abuse
	
	// if we're looking at a faculty journal page, insert the list of students
	if (facultyJournalUrl.test(document.location.href)) {
		stmarks_addFacultyJournalMenu();
	// if we're looking at the list of students (and we're faculty), link to the faculty journal page
	} else if (<?= ($userPrefs['role'] == 'faculty' ? 'true' : 'false') ?> && courseUsersUrl.test(document.location.href)) {
		stmarks_addFacultyJournalButton();
	}
}