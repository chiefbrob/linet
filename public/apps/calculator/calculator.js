/* @calculator */ 

console.log('@calculator script running');

$('.calculator-button').click(function(){

	var buttonValue = $(this).attr('value');

	var inputWindowContents = $('#inputWindow').val();
	
	$('#inputWindow').val(inputWindowContents + buttonValue);

});

$('.calculator-reset').click(function(){

	$('#inputWindow').val('');

});

$('.calculator-equal').click(function(){

	var result = eval($('#inputWindow').val());
	
	$('#inputWindow').val(result);

});