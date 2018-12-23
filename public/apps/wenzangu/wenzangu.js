/* @wenzangu */

console.log('@wenzangu script running');

function simjuiNiliyemtafuta(username){
	
	$.ajax({
		type: 'POST',
		url: 'wenzangu/rejectFriend',
		data: {_token: _getToken(), username: username },
		success: function(response) {

			
			console.log(response);

			
			wenzanguNiliowatafuta();
				
		},
		error: function() {
			
			alert('@wenzangu: Shida ilitokea ulipomkataa ' + username);
		},
	});
}

function namjuaMwenzangu(username){
	$.ajax({
		type: 'POST',
		url: 'wenzangu/acceptFriend',
		data: {_token: _getToken(), username: username },
		success: function(response) {

			
			console.log(response);

			
			wenzanguWalionitafuta();
			wenzanguWelcome();
				
		},
		error: function() {
			
			alert('@wenzangu: Shida ilitokea ulipomkataa ' + username);
		},
	});
}

function simjuiMwenzangu(username){
	$.ajax({
		type: 'POST',
		url: 'wenzangu/rejectFriend',
		data: {_token: _getToken(), username: username },
		success: function(response) {

			
			console.log(response);

			
			wenzanguWalionitafuta();
			wenzanguWelcome();
				
		},
		error: function() {
			
			alert('@wenzangu: Shida ilitokea ulipomkataa ' + username);
		},
	});
}



function wenzanguWalionitafuta(){
	
	$.ajax({
		type: 'POST',
		url: 'wenzangu/pendingFriendRequests',
		data: {_token: _getToken(), username: username() },
		success: function(response) {

			
			console.log(response);

			$('.wenzangu-walionitafuta').children('p').remove();

			if(response.length == 0)
			{
				var m = "<p>Hakuna mtu amekutafuta</p>";

				
				$('.wenzangu-walionitafuta').append(m);
			}
			else
			{
				for(var i = 0; i<response.length; i++)
				{
					var mwenzako = response[i];
					var $mwenzako = ''+
						'<p username="'+mwenzako.username+'">'+
			                mwenzako.name+' (@'+mwenzako.username+')'+
			                '<button class="button green-button namjua">Namjua</button>'+
			                '<button class="button red-button simjui">Simjui</button>'+
			            '</p>';

			        $('.wenzangu-walionitafuta').append($mwenzako);
				}

				 $('.wenzangu-walionitafuta').children('p').children('.namjua').click(function(){
				 	var username = $(this).parent().attr('username');
				 	namjuaMwenzangu(username);
				 });

				 $('.wenzangu-walionitafuta').children('p').children('.simjui').click(function(){
				 	var username = $(this).parent().attr('username');
				 	simjuiMwenzangu(username);
				 });
			}

				
		},
		error: function() {
			
			alert('@wenzangu: Hutukupata marafiki uliowatafuta');
		},
	});
}

function wenzanguNiliowatafuta(){
	
	$.ajax({
		type: 'POST',
		url: 'wenzangu/sentFriendRequests',
		data: {_token: _getToken(), username: username() },
		success: function(response) {

			


			console.log(response);

			$('.wenzangu-niliowatafuta').children('p').remove();
			

			if(response.length == 0)
			{
				var m = "<p>Hujatafuta mtu</p>";
				$('.wenzangu-niliowatafuta').append(m);
			}
			else
			{
				for(var i = 0; i<response.length; i++)
				{
					var mwenzako = response[i];

					var $mwenzako = ''+
						'<p username="'+mwenzako.username+'">'+
			                mwenzako.name+' (@'+mwenzako.username+')'+
			                '<button class="button red-button">Simjui</button>'+
			            '</p>';

					$('.wenzangu-niliowatafuta').append($mwenzako);
				}

				$('.wenzangu-niliowatafuta').children('p').children('button').click(function(){
					var username = $(this).parent().attr('username');
					simjuiNiliyemtafuta(username);
				});
			}


				
		},
		error: function() {
			
			alert('@wenzangu: Hutukupata marafiki wakoliokutafuta');
		},
	});

}

function wenzanguAdd(username){
	$.ajax({
		type: 'POST',
		url: 'wenzangu/addFriend',
		data: {_token: _getToken(), username: username },
		success: function(response) {

			console.log(response);

			if(response == 'LINET000'){

				alert(username  + ' amejulishwa. subiri akukubali')
				$('#jinaLaMwenzako').val('');

				$('.wenzangu-welcome').removeClass('hidden');
				$('.wenzangu-najuaMtu').addClass('hidden');
			}

			
				
		},
		error: function() {
			
			alert('@wenzangu: Failed to add user');
		},
	});
}

function wenzanguMessage(username){
	if(_runApp('ujumbe') == true)
	{
		setTimeout(ujumbeShowChat(username),2500);
	}
	else
	{
		console.log('@wenzangu: failed to start ujumbe');
	}
}

function wenzanguShow(username){
	$.ajax({
		type: 'POST',
		url: 'wenzangu/insight',
		data: {_token: _getToken(), username: username },
		success: function(response) {

			var me = response['me'];
			var friends = response['friends'];
			var pending = response['pending'];
			var sent = response['sent'];


			$('.wenzangu-preview').attr('username',me.username);

			$('.wenzangu-previewBody').children().remove();

			var icon = "uploads/avatars/"+me.avatar;



			$previewBody = ''+
				'<img src="'+ icon +'"/>'+
	            '<h3>'+me.name+'</h3>'+
	            '<p>@'+me.username+'</p>'+
	            '<p><a href="mailto:'+me.email+'">'+me.email+'</a></p>'+
	            '<p>'+me.phone+'</p>';

	        if($('body').attr('username') == me.username)
	        {
	        	$previewBody += '<button class="WenzanguEditProfile">My profile</button>';
	        }
	        else
	        {
	        	$previewBody += '<button class="WenzanguMessage">Message</button>';
	        }

	        $('.wenzangu-previewBody').append($previewBody);

	        $('.WenzanguMessage').click(function(){
	        	var username = $(this).parent().parent().attr('username');
	        	wenzanguMessage(username);
	        });

	        $('.WenzanguEditProfile').click(function(){
	        	window.location = 'profile';
	    	});

				
		},
		error: function() {
			
			alert('@wenzangu: Failed to load profile');
		},
	});
}

function wenzanguWelcome(){

	$.ajax({
		type: 'POST',
		url: 'wenzangu/myFriends',
		data: {_token: _getToken(), username: username() },
		success: function(response) {

			$('.wenzangu-list').children().remove();

			if(response.length == 0)
			{
				$('.wenzangu-list').append('<p>Huna marafiki!!</p>');
			}
			else
			{
				for(var i = 0; i<response.length; i++)
				{
					var mwenzangu = response[i];
					var icon = "uploads/avatars/"+mwenzangu.avatar;
					var $mwenzangu = ''+
					'<div class="mwenzangu" username="'+ mwenzangu.username +'">'+
	                	'<img src="'+icon+'" />'+
	                    '<b>'+ mwenzangu.name +'</b>'+
	                '</div>';

	                $('.wenzangu-list').append($mwenzangu);
				}

				$('.mwenzangu').click(function(){
					var username = $(this).attr('username');
					wenzanguShow(username);

				});
			}


			console.log(response);

				
		},
		error: function() {
			
			alert('@wenzangu: Hutukupata marafiki wako');
		},
	});
}

wenzanguShow(username());

wenzanguWelcome();

$('.najuaMtu').click(function(){
	$('.wenzangu-welcome').addClass('hidden');
	$('.wenzangu-najuaMtu').removeClass('hidden');
});

$('.walionitafuta').click(function(){
	$('.wenzangu-welcome').addClass('hidden');
	$('.wenzangu-walionitafuta').removeClass('hidden');
	wenzanguWalionitafuta();
});

$('.niliowatafuta').click(function(){
	$('.wenzangu-welcome').addClass('hidden');
	$('.wenzangu-niliowatafuta').removeClass('hidden');
	wenzanguNiliowatafuta();
});

$('.wenzangu-home').click(function(){
	$('#wenzangu').children('.application-body').children('.application-view').addClass('hidden');
	$('.wenzangu-welcome').removeClass('hidden');
	wenzanguWelcome();
});


$('.wenzangu-kubali').click(function(){
	var username = $('#jinaLaMwenzako').val();

	if(username !== '')
	{

		wenzanguAdd(username);

	}

});