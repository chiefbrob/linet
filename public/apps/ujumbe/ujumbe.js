/* @ujumbe */

console.log('@ujumbe script running');

$('.ujumbe-welcome').children().remove();

function ujumbeShowChat(username){
	console.log('@ujumbe: Showing chat for ' + username);
	
	$.ajax({
		type: 'POST',
		url: 'ujumbe/chats/'+username,
		data: {_token: _getToken() },
		success: function(response) {

			console.log('@ujumbe: chat loading for ' + username + ' SUCCESS');

			var user = response[0][1];
			var otherUser = response[0][0];
			var messages = response[1];

			$('.ujumbe-preview').addClass('hidden');
			var $chatArea = $('#ujumbe-'+otherUser.username);
			$chatArea.children('.ujumbe-previewBody').children('p').remove();
			for(var i = messages.length-1; i>=0; i--)
			{
				var message = messages[i];
				var direction = "ujumbe-messageIn";

				if(message.sender == user.id)
					direction = "ujumbe-messageOut";

				var $message = ''+
					'<p class="'+direction+'">'+
						message.contents +
						'<span>'+message.updated_at + '</span>'+
					'</p>';
				$chatArea.children('.ujumbe-previewBody').append($message);

			}
			$chatArea.removeClass('hidden');

			clearInterval(ujumbeSync);

			ujumbeSync = setInterval(ujumbeShowChat,5000,username);


		},
		error: function() {
			
			console.log('@ujumbe: chat loading for ' + username + ' FAILED');
		},
	});

}

function ujumbeSend(username,contents){
	$.ajax({
		type: 'POST',
		url: 'ujumbe',
		data: {_token: _getToken(), username: username, contents: contents },
		success: function(response) {

			if(response == "LINET000")
			{
				console.log("@ujumbe: Message to " + username + " sent SUCCESSFULLY");
				ujumbeShowChat(username);
			}
			else
			{
				console.log("@ujumbe: Message to " + username + " FAILED");
			}
			

			
				
		},
		error: function() {
			
			console.log('@ujumbe: Message sending to ' + username + " FAILED");
		},
	});
}


function ujumbeWelcome(){

	$.ajax({
		type: 'POST',
		url: 'wenzangu/myFriends',
		data: {_token: _getToken(), username: username() },
		success: function(response) {

			console.log('@ujumbe: Friend list loading SUCCESS');

			if(response.length == 0)
			{

				var $p = ''+
					'<p>Ujumbe yakuwezesha kuzungumza na marafiki wako.'+
					'Kwa sasa, huna marafiki. <br><br>'+
					'<button id="ujumbe-tafutaMarafiki">Tafuta marafiki</button>'+
					' </p>';
				$('.ujumbe-welcome').append($p);
				$('#ujumbe-tafutaMarafiki').click(function(){
					console.log('@ujumbe: Switching to Wenzangu app');
					_runApp('wenzangu');
				});

			}
			else
			{

				var $template = ''+
					'<div class="ujumbe-header"></div>'+
					'<div class="ujumbe-body">'+
						'<div class="ujumbe-list"></div>'+
					'</div>';

				$('.ujumbe-welcome').append($template);

				for(var i = 0; i<response.length; i++)
				{
					var friend = response[i];

					var $mwenzako = ''+
					'<div class="ujumbe-listItem" username="'+ friend.username +'">'+
	                    '<h4>'+ friend.name +'</h4>'+
	                '</div>';

					$('.ujumbe-list').append($mwenzako);

					$('.ujumbe-listItem').click(function(){

						$('.ujumbe-listItem').removeClass('activeChat');

						$(this).addClass('activeChat');

						var username = $(this).attr('username');

						ujumbeShowChat(username);

					});

					$mwenzako = ''+
					'<div id="ujumbe-'+friend.username+'" class="ujumbe-preview hidden" username="'+friend.username+'">'+
						'<div class="ujumbe-previewHeader">'+
							'<h3>'+friend.name+'</h3>'+
							'<p>@'+friend.username+'</p>'+
						'</div>'+
						'<div class="ujumbe-previewBody">'+
						'</div>'+
						'<div class="ujumbe-previewFooter">'+
							'<textarea rows="2" placeholder="andika hapa"></textarea>'+
							'<button class="ujumbe-sendButton">TUMA</button>'+
						'</div>'+
					'</div>';

					$('.ujumbe-body').append($mwenzako);

					$('.ujumbe-sendButton').click(function(){
						var username = $(this).parent().parent().attr('username');
						//var username = $('.ujumbe-preview').attr('username');
						var contents = $(this).parent().children('textarea').val();

						if(contents !== '')
						{
							ujumbeSend(username,contents);
							$(this).parent().children('textarea').val('');
						}

					});


				}

				ujumbeShowChat(response[0].username);


			}

		},
		error: function() {
			
			console.log('@ujumbe: Friends list loading FAILED');
		},
	});

}

setTimeout(ujumbeWelcome,1019);

var ujumbeSync;
clearInterval(ujumbeSync);




//hide app contents
//load friend list
	//if friends
		//prepare interface
		//load all chats
		//start sync
	//else
		//inform user they got no friends
		//show user how to find friends