<?php

require_once __DIR__ . '/../common.inc.php';

?>
var canvashack = {
	courseHomeUrl: /.*\/courses\/\d+$/,
	courseUsersUrl: /.*\/courses\/\d+\/users$/,
	courseId: /.*\/courses\/(\d+)/,
	facultyJournalUrl: /.*\/users\/(\d+)\/user_notes\?course_id=(\d+)&course_name=([^&]+)/,

	addButton: function(container) {
		var firstStudentId = <?= $pluginMetadata['PLACEHOLDER_USER_ID'] ?>;
		if ($('.StudentEnrollment').length > 0) {
			firstStudentId = $('.StudentEnrollment')[0].id.substr(5);
		}
		$(container).append('<a class="btn button-sidebar-wide" href="/users/' + firstStudentId + '/user_notes?course_id=' + this.courseId.exec(document.location.href)[1] + '&course_name=' + encodeURI($('#breadcrumbs li.home').next().find('span').text()) +'"><i class="icon-discussion" role="presentation"></i> Faculty Journal</a>');
	},

	addMenu: function() {
		var self = this;
		$('#content').ready(function() {
			
			var userId = self.facultyJournalUrl.exec(document.location.href)[1];
			var courseId = self.facultyJournalUrl.exec(document.location.href)[2];
			var courseName = self.facultyJournalUrl.exec(document.location.href)[3];
			
			/* insert menu */
			$("#content").prepend('<iframe id="canvashack-faculty-journal" src="<?= $pluginMetadata['PLUGIN_URL'] ?>/menu.php?course_id=' + courseId + '&user_id=' + userId + '&course_name=' + courseName + '"></	iframe>');
			
			/* add course to breadcrumbs */
			$('#breadcrumbs li.home').after('<li><a href="/courses/' + courseId + '">' + decodeURI(courseName) + '</a></li>')
			
			/* warn about printing comments */
			$('#user_note_list').before('<div id="canvashack-faculty-journal-confidential" class="alert alert-danger"><h3>Confidential</h3><p>These notes are written by faculty specifically for an audience of fellow faculty, with the understanding that observations and feedback are honest, but may not be sufficiently polished to present directly to families. <strong>Please respect this confidentiality by not sharing these comments with students or parents.</strong></p></div>');
			
			/* make it harder to copy and paste */
			$('body').bind({
				copy: self.blockClipboard,
				cut: self.blockClipboard
			});
		});
	},
	
	blockClipboard: function() {
		$('body').append('<div id="block-clipboard">Faculty Journal entries are confidential.</div>');
		window.getSelection().selectAllChildren($('#block-clipboard')[0]);
		window.setTimeout(function() {
			$('#block-clipboard').remove();
		}, 100);
	},
	
	loadInterface: function() {
		
		/* are we in the Faculty Journal, needing the menu? */
		if (this.facultyJournalUrl.test(document.location.href)) {
			this.addMenu();
			
		/* or are we on the Users page of the course, needing a button? */
		} else if (this.courseUsersUrl.test(document.location.href) && (ENV.current_user_roles.indexOf('teacher') > 0 || ENV.current_user_roles.indexOf('admin') > 0)) {
			var self = this;
			$('#content .roster .StudentEnrollment').ready(function() {
				self.addButton('.ic-Action-header__Primary');
			});
			
		/* or are we on the home page of the course, needing a button? */
		} else if (this.courseHomeUrl.test(document.location.href) && (ENV.current_user_roles.indexOf('teacher') > 0 || ENV.current_user_roles.indexOf('admin') > 0)) {
			this.addButton('#course_show_secondary .course-options');
		}
	}
};