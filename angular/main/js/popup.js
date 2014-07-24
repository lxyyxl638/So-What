var global_obj = {};


$(document).ready(function(){
	$("#model-dialog").hide();
	$("#top-add-question").click(function(){
		$("#model-dialog").fadeToggle();
	});
	$("#model-dialog-title-close").click(function(){
		$("#model-dialog").fadeOut();
	});
});