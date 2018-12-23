/* @tumanashop */

console.log('@tumanashop script running');

$('.tumanashop-application').remove();

tumanashop = {
	all: false,
	installed: false,
};

function tumanashopAppStatus(username){
	for(var i =0; i<tumanashop.installed.length; i++)
	{
		var app = tumanashop.installed[i];

		if(app.username == username)
			return 'installed';
	}

	for(var i =0; i<tumanashop.all.length; i++)
	{
		var app = tumanashop.all[i];

		if(app.username == username)
			return 'exists';
	}

	return 'invalid';

}

function tumanashopAction(username){
	if(tumanashopAppStatus(username) == 'installed')
		return tunamashopUninstall(username);
	else
		return tumanashopInstall(username);
}

function tumanashopInstall(username){
	$.ajax({
		type: 'POST',
		url: 'api/install-application',
		data: {_token: _getToken(), username: username },
		success: function(response) {

			//console.log(response);

			if(response[0] == 'LINET000'){
				alert('Programu iko tayari');

				var app = response[1];

				_installApp(app.username);

			}
			else
			{
				alert('Programu hakijawekwa');
			}
				
		},
		error: function() {
			
			alert('Programu hakijawekwa');
		},
	});
}
function tunamashopUninstall(username){
	$.ajax({
		type: 'POST',
		url: 'api/uninstall-application',
		data: {_token: _getToken(), username: username },
		success: function(response) {

			//console.log(response);

			if(response[0] == 'LINET000'){

				alert('Programu imetolewa');

				var app = response[1];

				_uninstallApp(app.username);

			}
			else
			{
				alert('Programu haijatolewa');
			}
				
		},
		error: function() {
			
			alert('Programu haijatolewa');
		},
	});
}

function tumanashopWelcome(){
	$.ajax({
		type: 'POST',
		url: 'api/applications',
		data: {_token: _getToken() },
		success: function(response) {

			//console.log(response);

			tumanashop.all = response['all'];

			tumanashop.installed = response['installed'];

			$('.tumanashop-application').remove();

			for(var i = 0; i<tumanashop.all.length; i++)
			{
				var app = tumanashop.all[i];

				var status = tumanashopAppStatus(app.username);

				if(app.username == 'tumanashop')
				{
					continue;
				}



				var $app = ''+
				'<div username="'+app.username+'" class="tumanashop-application">'+
		            '<img src="images/icons/icon-'+app.icon+'.png">'+
		            '<h4>'+app.username+'</h4>';
		        if(status == 'installed')
		        	$app += '<button>Toa</button>';
		        else
		        	$app += '<button>Weka</button>';
		        $app += ''+
		        '</div>';

		        $('.tumanashop-welcome').append($app);


			}

			$('.tumanashop-application').children('button').click(function(){
				var username = $(this).parent().attr('username');
				tumanashopAction(username);
				tumanashopWelcome();
			});
				
		},
		error: function() {
			
			console.log('@tumanashop: Failed to load applications');
			console.log('Failed to load applications');
		},
	});
}

tumanashopWelcome();

