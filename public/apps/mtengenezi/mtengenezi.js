/* @mtengenezi */

console.log('@mtengenezi script running');

var mtengenezi = {
	app: false,
	data: false,
	script: false,
	style: false,
};

function mtengeneziLocalSync(){

	var $mtengeneziEditor = $('#mtengenezi-editor');

	var activeFile = {
		name: $mtengeneziEditor.children('textarea').attr('file'),
		content: $mtengeneziEditor.children('textarea').val(),
	};

	switch(activeFile.name){
		case 'script':
			mtengenezi.script = activeFile.content;
			break;
		case 'style':
			mtengenezi.style = activeFile.content;
			break;
		case 'data':
			mtengenezi.data = activeFile.content;
			break;
		default:
			console.log('file name error');
			return false;
			break;

	};

	return true;
}

function mtengeneziLoad(username){

	//load application into editor

	$.ajax({
		type: 'POST',
		url: '/api/mtengenezi-loadApp',
		data: {_token: _getToken(), username: username, },
		success: function(response) {

			

			mtengenezi.app = response[0];
			mtengenezi.data = response[1];
			mtengenezi.script = response[2];
			mtengenezi.style = response[3];

			var $mtengeneziEditor = $('#mtengenezi-editor');

			$mtengeneziEditor.attr('username',mtengenezi.app.username);

			var $description = '<b class="right-side">' + mtengenezi.app.name + ' :: script.js</b>';
			$mtengeneziEditor.children('.mtengenezi-header').children('b').remove();
			$mtengeneziEditor.children('.mtengenezi-header').append($description);

			$mtengeneziEditor.children('textarea').val('');
			$mtengeneziEditor.children('textarea').val(mtengenezi.script);

			$('.mtengenezi-welcome').addClass('hidden');
			$('.mtengenezi-editor').removeClass('hidden');

			$mtengeneziEditor.children('textarea').attr('file','script');

		},
		error: function() {
			
			console.log('Mtengenezi failed to load app ' + username);
		},
	});

}

function mtengeneziCommit(){

	mtengeneziLocalSync();


	$.ajax({
		type: 'POST',
		url: '/api/mtengenezi-commitApp',
		data: {
			_token: _getToken(), 
			username: mtengenezi.app.username,
			data: mtengenezi.data,
			script: mtengenezi.script,
			style: mtengenezi.style, 
		},
		success: function(response) {

			//console.log(response);

			if(response == 'LINET000')
				alert('Programu imebadilishwa');
			else
				alert('Programu haijabadilishwa');

		},
		error: function() {
			
			console.log('Mtengenezi failed to commit app ' + mtengenezi.app.username);
		},
	});
}

function mtengeneziWelcome(){
	//this function prepates welcome page
	$.ajax({
		type: 'POST',
		url: '/api/mtengenezi-myApps',
		data: {_token: _getToken(), },
		success: function(response) {

			console.log('Applications loaded ');

			$('#mtengenezi-YourApplications').children().remove();

			if(response.length == 0)
			{
				var $mtengeneziYourApplication = '<li>Hakuna viumbe vya Linet vya kuonyesha hapa!</li>';			

				$('#mtengenezi-YourApplications').append($mtengeneziYourApplication);

				return;
			}

			for(var i = 0; i<response.length; i++)
			{
				var $mtengeneziYourApplication = ''+
				'<li username="' + response[i].username + '">'+ 
					response[i].name +
					'<button class="button mtengeneziYourApplication">Tengeneza</button>'+
				'</li>';	

				$('#mtengenezi-YourApplications').append($mtengeneziYourApplication);
			}

			$('.mtengeneziYourApplication').click(function(){
				var username = $(this).parent().attr('username');

				mtengeneziLoad(username);	
			});



		},
		error: function() {
			
			console.log('Failed to load applications');
		},
	});
}

mtengeneziWelcome();

$('.mtengenezi-editor').children('.mtengenezi-header').children('button').click(function(){

	var action = $(this).attr('action');

	switch(action){
		case 'test':

			var username = $(this).parent().parent().attr('username');
			console.log(username);
			_runApp(username);
			break;

		case 'exit':

			$('.mtengenezi-actionPane').children('button').each(function(){
				if($(this).attr('file') == 'script')
					$(this).removeClass('green-button').addClass('red-button');
				else
					$(this).removeClass('red-button').addClass('green-button');
			});
			$(this).parent().children('button').removeClass('red-button').addClass('green-button');
			$(this).removeClass('green-button').addClass('red-button');

			$('.mtengenezi-welcome').removeClass('hidden');
			$('.mtengenezi-editor').addClass('hidden');

			break;

		case 'commit':

			
			mtengeneziCommit();

			break;

		default:
			console.log('action not understood');
			break;
	}
});

$('.mtengenezi-actionPane').children('p').children('button').click(function(){

	$(this).parent().children('button').removeClass('red-button').addClass('green-button');
	$(this).removeClass('green-button').addClass('red-button');

	var $mtengeneziEditor = $('#mtengenezi-editor');

	var fileToDisplay = $(this).attr('file');

	console.log(fileToDisplay);

	mtengeneziLocalSync();

	$mtengeneziEditor.children('textarea').val('');

	switch(fileToDisplay){
		case 'data':
			$mtengeneziEditor.children('textarea').val(mtengenezi.data);
			var $description = '<b class="right-side">' + mtengenezi.app.name + ' :: data.html</b>';
			break;

		case 'style':
			$mtengeneziEditor.children('textarea').val(mtengenezi.style);
			var $description = '<b class="right-side">' + mtengenezi.app.name + ' :: style.css</b>';
			break;

		case 'script':
			$mtengeneziEditor.children('textarea').val(mtengenezi.script);
			var $description = '<b class="right-side">' + mtengenezi.app.name + ' :: script.js</b>';
			break;

		default:

			break;
	};

	$mtengeneziEditor.children('textarea').attr('file',fileToDisplay);

	
	$mtengeneziEditor.children('.mtengenezi-header').children('b').remove();
	$mtengeneziEditor.children('.mtengenezi-header').append($description);
	
});




$('.mtengenezi-appMaker').children('p').children('button').click(function(){
	var action = $(this).attr('action');

	switch(action){
		case 'make':
			var mtengenezi_app = {
				name: $('#mtengenezi-appName').val(),
				username: $('#mtengenezi-appUsername').val(),
				description: $('#mtengenezi-appDescription').val(),
			};

			if(mtengenezi_app.name == '')
			{
				alert('Jina la programu ililopeana sio sahihi');
				return;
			}

			if(mtengenezi_app.username == '')
			{
				alert('Jina la mtandao la programu sio sahihi');
				return;
			}

			$.ajax({
				type: 'POST',
				url: 'applications',
				data: {
					_token: _getToken(), 
					username: mtengenezi_app.username,
					name: mtengenezi_app.name,
					description: mtengenezi_app.description,
				},
				success: function(application) {

					mtengeneziWelcome();
					
					alert(application.name + ' imetengenezwa vikamilifu!! ');

					
					$('.mtengenezi-newApp').addClass('hidden');
					$('.mtengenezi-welcome').removeClass('hidden');
					
				},
				error: function() {
					
					console.log('Failed to make application');
				},
			});

			break;

		case 'cancel':
			$('.mtengenezi-newApp').addClass('hidden');
			$('.mtengenezi-welcome').removeClass('hidden');
			break;
	};

});

$('#mtengenezi-makeNewApp').click(function(){
	$('.mtengenezi-welcome').addClass('hidden');
	$('.mtengenezi-newApp').removeClass('hidden');
});