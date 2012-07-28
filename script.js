// Prevent multiple submissions while a question is being graded.
// Done by adding the id attribute containing the word "grading",
// which is detected by the CSS and used to grey the text. Subsequent
// clicks are then ignored. [Seems complex but simply disabling the 
// button doesn't work as Moodle then won't correctly postprocess the
// click.]

// TODO Get the "Grading, please wait" message from the lang file somehow.

YUI().use('node', function(Y) {
	Y.on("domready", function() {

    	var editor = ace.edit("ace-editor");
    	editor.setTheme("ace/theme/vibrant_ink");
    	editor.getSession().setMode("ace/mode/java");
    	var textarea = Y.one('textarea[class=progcode-answer]').hide();
    	var code = editor.getSession().getValue();
    	textarea.set('value', code);
    	editor.getSession().on('change', function() {
	    	var code = editor.getSession().getValue();
    		textarea.set('value', code);
    		//console.log(code);
	    });
    });
});

function submitClicked(e) {
	var evt = window.event || e  //cross browser event object
	if (!evt.target) // More cross browser hacks
		evt.target = evt.srcElement

	if (!evt.target.id) {
		evt.target.id = evt.target.name + " grading"
		evt.target.value = "Grading, please wait"
	}
	else {
		if (evt.preventDefault) { //supports preventDefault?
			evt.preventDefault()
		}
		else  {//IE
			return false
		}
	}
}