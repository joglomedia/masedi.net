function addTag(tag) {
	var myField;
	if (!(myField = document.getElementById('emailContent'))) {
        return false;
	}
    
	if (document.selection) {
		myField.focus();
		sel = document.selection.createRange();
		sel.text = '{#' + tag + '}';
		myField.focus();
	}
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		var cursorPos = endPos;
		myField.value = myField.value.substring(0, startPos)
					  + '{#' + tag + '}'
					  + myField.value.substring(endPos, myField.value.length);
		cursorPos += tag.length + 3;
		myField.focus();
		myField.selectionStart = cursorPos;
		myField.selectionEnd = cursorPos;
	}
	else {
		myField.value += tag;
		myField.focus();
	}
}
function addSubjectTag(tag) {
    var myField;
    if (!(myField = document.getElementById('emailSubject'))) {
        return false;
    }
    myField.value += tag;
    myField.focus();
}