var faculty_journal_menu = {
	
	canvasInstance: null,
	course: null,
	
	init: function(pluginUrl, canvasInstance, course, name, user) {
		this.canvasInstance = canvasInstance;
		this.course = course;
		$.getScript(pluginUrl + '/js/student-loader.js.php?course_id=' + course + '&user_id=' + user + '&course_name=' + name, function() {
			faculty_menu_student_loader.go();
		});
	},
	
	update: function() {
		top.location.href = this.canvasInstance + '/users/' + $('#students :selected').val() + '/user_notes?course_id=' + this.course + '&course_name=' + /course_name=([^&]+)/.exec(window.location.href)[1];
	},
	
	nextStudent: function() {
		$('#students').val($('#students :selected').next().val());
		if ($('#students :selected').val() === undefined) {
			$('#students').val($('#students option:first-child').val());
		}
		this.update();
	},
	
	previousStudent: function() {
		$('#students').val($('#students :selected').prev().val());
		if ($('#students :selected').val() === undefined) {
			$('#students').val($('#students option:last-child').val());
		}
		this.update();
	}
}
