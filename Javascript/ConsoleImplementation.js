
$(document).ready(function(){
	
	var allCommands;

	$(document).on("keydown", function(event){
		if (event.keyCode == 13) {
			event.preventDefault();
			var input = $("#input").val();
			var result = execute(input);
			$("#input").val("");
			$("#result").val(result);
		}
	});
	
	function execute(command){
		var oldCOmmands = allCommands;
		allCommands = (allCommands && allCommands + ";" + command) || command;
		try {
			eval(allCommands); 
			var result = eval(allCommands);
			console.log(allCommands);
			result = result || findSuccessMessage(allCommands);
			return result;
		} catch (e) {
			/*if (e instanceof SyntaxError) {
				alert(e.message);
			}*/
			allCommands = oldCOmmands;
			console.log(allCommands);
			console.log(e.message);
			return "Oops. U made a mistake silly boy";
		}
		//var result = eval(command);
		//if(result){
		//}
		/*console.log(allCommands);
		alert(result)
		return result;*/
	}

/*	(function() {
    var exLog = console.log;
    console.log = function(msg) {
        exLog.apply(this, arguments);
        alert(msg);
    }
})()*/

	function findSuccessMessage(allCommands){
		var message;
		if(allCommands.length < 10) {
			message = successMessages[0];
		} else if (allCommands.length >= 10 && allCommands.length < 20) {
			message = successMessages[1];
		} else if (allCommands.length >= 20 && allCommands.length < 40) {
			message = successMessages[2];
		} else if (allCommands.length >= 40 && allCommands.length < 70) {
			message = successMessages[3];
		} else if (allCommands.length >= 70) {
			message = successMessages[4];
		}
		return message;
	}
	
	var successMessages = ["GJ. Keep up", "Damn, u r good", "U r even better me!!", "R u John Resig? WTF", "ok, i quit"];

});