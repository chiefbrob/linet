/* @mwalimu */

console.log('@mwalimu script running');

$('.mwalimu-soma').click(function(){

	var video = $(this).parent().attr('username');

	$('.mwalimu-darasaniVideo').remove();

	var location = 'videos/'+video+'.mp4';

	console.log(location);

	$video = ''+
	'<video src="'+location+'"  controls="true" class="mwalimu-darasaniVideo">'+
		'Darasa haliko leo'+
	'</video>';

	$('.mwalimu-darasani').prepend($video);

	$('.mwalimu-welcome').addClass('hidden');
	$('.mwalimu-darasani').removeClass('hidden');

});

$('.mwalimu-classes').click(function(){

	$('.mwalimu-darasaniVideo').remove();

	$('.mwalimu-welcome').removeClass('hidden');
	$('.mwalimu-darasani').addClass('hidden');

});