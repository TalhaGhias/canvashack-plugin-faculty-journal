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
		var nextInSection = $('#students :selected').next().val(),
			firstInNextSection = $('#students :selected').parent().next().find('option:first-child').val(),
			firstStudent = $('#students option:first-child').val(),
			next = null;
			
		if (nextInSection === undefined) {
			if (firstInNextSection === undefined) {
				next = firstStudent;
			} else {
				next = firstInNextSection;
			}
		} else {
			next = nextInSection;
		}
		
		$('#students').val(next);
		this.update();
	},
	
	previousStudent: function() {
		var prevInSection = $('#students :selected').prev().val(),
			lastInPrevSection = $('#students :selected').parent().prev().find('option:last-child').val(),
			lastStudent = $('#students optgroup:last-child option:last-child').val(),
			prev = null;
			
		if (prevInSection === undefined) {
			if (lastInPrevSection === undefined) {
				prev = lastStudent;
			} else {
				prev = lastInPrevSection;
			}
		} else {
			prev = prevInSection;
		}
		
		$('#students').val(prev);
		this.update();
	}
}
