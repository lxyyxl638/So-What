var global_obj = {};


$(document).ready(function(){
	$("#top-add-question").click(function(){
		$("#model-dialog").fadeToggle();
	});
	$("#model-dialog-title-close").click(function(){
		$("#model-dialog").fadeOut();
	});
});