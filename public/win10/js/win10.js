/* win10 code */

$().ready(function(){


	
	console.log('WIN10: initializing ...');
	
	var loadingTime = 519;

	var _win10 = {
		username: 'win10',
		apps: new Array(),
		runningApps: new Array(),
		status: 'initializing',
		data: {
			installedApps: new Array(),
			components: new Array(),
			notifications: new Array(),
		},

		boot: function(){
			
			console.log('WIN10: Classic Desktop');

			//components required by win10 template

			var c = new Array('main','notifications','launcher','taskbar');

			//downloading the components listed and mounting them to display
			this.components(false,'win10-newComponents',c);

			//win10-application defines applications layout. here we load the style
			this.components('win10-application','win10-applyStyle',false);

			//now, we wait for the components to finish doing their thing to proceed
			setTimeout(function(){

				//here, we load user's data
				/*
					0 - "LINET000"
					1 - apps
					2 - notifications

				*/

				$.ajax({
					type: 'POST',
					url: 'api/user-data',
					data: {_token: _getToken() },
					success: function(data) {

						console.log('WIN10: user data loaded');

						//here, we clean the win10 template						
						$('.launcher-applications').children('.launcher-application').remove();
						$('.notifications-container').children('.notification').remove();
						
						var l = {
							status: data[0],
							apps: data[1],
							notifications: data[2],
						};

						if(l.status !== 'LINET000')
						{
							console.log('WIN10: failed to load user data');
							return;
						}
						
						_win10.data.installedApps = l.apps;
						
						_win10.data.notifications = l.notifications;
						

						//adding apps to the launcher
						for(var i = 0; i< l.apps.length; i++)
						{
							var app = l.apps[i];

							var $app = ''+
							'<div class="launcher-application" username="'+app.username+'">'+
				            	'<img src="images/icons/icon-'+app.icon+'.png" title="'+app.name+'" />'+
				                '<span>'+app.name+'</span>'+
				            '</div>';

				            $('.launcher-applications').append($app);
						}

						//adding functionality when app in launcher is clicked
						$('.launcher-application').click(function(){

							runApp($(this).attr('username'));

						});
						

						//adding received notifications into notifications pane
						for(var i = 0; i< l.notifications.length; i++)
						{
							var notification = l.notifications[i];
							
							

							var $notification = ''+
							'<div class="notification taarifa" username="'+notification.sender+'" notification="'+notification.id+'">'+
				            	'<span>'+
				                    notification.contents+
				                '</span>'+
				                '<br />'+
				                '<b class="right-side">@'+notification.sender+'</b>'+
				            '</div>';

				            $('.notifications-container').append($notification);
						}
						
						//adding functionality when a notification is clicked
						$('.notifications-container').children('.taarifa').click(function(){
							var username = $(this).attr('username');
							$(this).remove();
							runApp(username);
						});


						//running first app, or mwalimu app						
						if(_firstApp() !== 'none')
							runApp(_firstApp());
						else
							runApp('mwalimu');
						
						//adding functionality to win10 action buttons
						$('.win10-actionButton').click(function(){

							var action = $(this).attr('action');
					
							console.log('WIN10: ' + action + ' being performed');

							if(action == "toggleLauncher")
								_components('win10-launcher','win10-toggleMountedState',false);	

							if(action == "toggleNotification")
								_components('win10-notifications','win10-toggleMountedState',false);

							if(action == "hideNotifications")
								_components('win10-notifications','win10-componentMount',false);
										
						});
						

					},
					error: function() {
						
						console.log('WIN10: Failed to mount component');
					},
				});
				

			},1);		

		},
		reboot: function(){
			//closing applications
			this.appApi(false,"shutdown-all",true);		},
		shutdown: function(){

			this.appApi(false,"shutdown-all",true);

			_components('win10','unmount',true);
			_components('win10-notifications','unmount',true);
			_components('win10-launcher','unmount',true);
			_components('win10-taskbar','unmount',true);	

			_components('win10-application','removeStyle',false);	},
		getStatus: function(){

			return this.status;		},

		installApp: function(username){

			$.ajax({
				type: 'GET',
				url: 'applications/'+username,
				data: {_token: _getToken() },
				success: function(response) {

					var app = response[0];

					console.log('WIN10: '+app.username+' is ready for use');

					_win10.data.installedApps[_win10.data.installedApps.length] = app;

					var $app = ''+
							'<div class="launcher-application" username="'+app.username+'">'+
				            	'<img src="images/icons/icon-'+app.icon+'.png" title="'+app.name+'" />'+
				                '<span>'+app.name+'</span>'+
				            '</div>';

					$('.launcher-applications').append($app);

					$('.launcher-application').click(function(){

						_runApp($(this).attr('username'));
						_components('win10-launcher','win10-componentMount',false);	
						_components('win10-notifications','win10-componentMount',false);	

					});
						
				},
				error: function() {
					
					console.log('WIN10: failed to load application');
					
				},
			});

		},
		runApp: function(username){
			
			if(_appStatus(username) == "not-installed")
			{
				console.log('WIN10: '+ username + ' not installed. Launching tumanashop');
				runApp('tumanashop');
				return false;
			}
			
			if(_appStatus(username) == "running")
			{
				
				return false;
			}
				


			this.runningApps[this.runningApps.length] = _makeApp(username);

			var id = this.getAppId(username);

			return this.runningApps[id].boot(true);		
			
			},
		getAppId: function(username){
			for(var i = 0; i<this.runningApps.length; i++)
			{
				if(this.runningApps[i].username == username)
					return i;
			}		},
		stopApp: function(username){

			if(this.appStatus(username) == 'running')
			{
				//console.log(username + "Close();");

				var newApps = new Array();

				var id = this.appApi(username,"getAppId",false);

				for(var i = 0; i<this.runningApps.length; i++)
				{
					if(username !== this.runningApps[i].username)
					{
						newApps[newApps.length] = this.runningApps[i];
					}

				}

				this.runningApps = newApps;

				$('.application').each(function(){
					var u = $(this).attr(username);

					if(u == username){

						$(this.addClass('hidden'));
					}
				});

				console.log('WIN10: @' + username + ' stopped');
				
				return true;
			}
			
			return false;		},
		uninstallApp: function(username){

			this.stopApp(username);	

			var id = this.getAppId(username);

			var installedApps = this.data.installedApps;

			this.data.installedApps = new Array();

			for(var i = 0; i < installedApps.length; i++)
			{
				var installedApp = installedApps[i];
				if(installedApp.username !== username)
				{
					this.data.installedApps[this.data.installedApps.length] = installedApp;
				}
				else
				{
					console.log("WIN10: "+username+" has been uninstalled");

					$('.launcher-application').each(function(){
						if($(this).attr('username') == username)
							$(this.remove());
					});

					$('#win10-taskbar').children('.middle-section').children('img').each(function(){
						if($(this).attr('username') == username)
							$(this.remove());
					});

				}
			}


		},
		appApi: function(username,action,parameters){

			switch(action){
				case "getAppId":

					var status = this.appApi(username,'status',false);
					
					if(status == "not-installed" || status == "not-running")
						return -1;
					for(var i = 0; i<this.runningApps.length; i++)
					{
						if(this.runningApps[i].username == username)
							return i;
					}
					console.log("LINET008 : "+ username); //app api failure
					return -1;

					break;
				case "run":
					//code that prepares an application

					setTimeout(function(){

						if(parameters)
							_appApi(username,'focus',false);

						$('.application-closeButton').click(function(){

							var username = $(this).attr('username');
							
							_appApi(username,'shutdown',true);
							
						});

					},loadingTime*2);

					

					break;
				case "focus":

					console.log('WIN10: @' + username + ' has focus');


					this.appApi(false,'lose-focus',false);

					setTimeout(function(){
						
						$('#'+username).removeClass('hidden');

						var $taskbar = $('#win10-taskbar');
						var exist = false;
						$taskbar.children('.middle-section').children('img').each(function(){
							if($(this).attr('username') == username)
								exist = true;
						});
						if(!exist)
						{
							//var taskbarIcon = _appIcon(username);
							
							var appIcon = false;
														
							for(var i = 0; i < _win10.data.installedApps.length; i++)
							{
								var app = _win10.data.installedApps[i];
								
								if(username == app.username)
								{
									
									appIcon = app.icon;	
									break;
								}
												
							}
							
							if(!appIcon)
								appIcon = 'app';
							

							var $taskbarApp = ''+
							'<img src="images/icons/icon-'+
									appIcon+
									'.png" '+
								'class="icon" username="'+ username+'" '+
								'title="'+ username+'" />';

							$taskbar.children('.middle-section').append($taskbarApp);

							$taskbar.children('.middle-section').children('.icon').each(function(){
								if($(this).attr('username') == username)
								{
									$(this).click(function(){
										var username = $(this).attr('username');
										_appApi(username,'focus',true);
									});
								}
							});
							
						}

					},loadingTime);

					

					break;
				case "lose-focus":
					if(username == false)
					{
						for(var i = 0; i< this.runningApps.length; i++)
						{
							this.appApi(this.runningApps[i].username,"lose-focus",false);
						}
					}
					else
					{
						
						$('#'+username).addClass('hidden');
					}

					break;
				case "status":

					//first we check if app is installed
					
					if(!this.appApi(username,"install-status",false))
					{
						return "not-installed";
					}

					//next, we check if app is already running

					if(!this.appApi(username,"run-status",false))
					{
						return "not-running";
					}

					//lastly, we get the app's id and return its status

					var id = this.getAppId(username);
					return this.runningApps[id].getStatus();
					break;
				case "status-update":

					if(this.appStatus(username) == 'running')
					{
						var id = this.getAppId(username);
						this.data.runningApps[id].status = parameters;

						console.log('WIN10: '+username + ' new status is ' + parameters);

						return true;
					}
					return false;
					break;
				case "shutdown":
					
					$('#win10-taskbar').children('.middle-section').children('img').each(function(){
						if($(this).attr('username') == username)
							$(this).remove();
					});

					var id = this.appApi(username,"getAppId",false);

					return this.runningApps[id].shutdown();

					break;

				case "shutdown-all":
					for(var i = 0; i<this.runningApps.length; i++)
						this.appApi(this.runningApps[i].username,"shutdown",parameters);
					break;
				case "install-status":
						
					var installed = false;
				
					for(var i = 0; i < this.data.installedApps.length; i++)
					{
						if(this.data.installedApps[i].username == username)
							return true;
					}

					if(!installed)
					{
						console.log('WIN10: ' + username + ' not installed');
						return false;
					}
					break;
				case "run-status":

					//first, we check if app is installed
					if(!this.appApi(username,"install-status",false))
						return false;


					//next, we check in the array of running apps
					for(var i = 0; i < this.runningApps.length; i++)
					{
						if(this.runningApps[i].username == username)
							return true;
					}

					return false;
					break;

				default:

					break;
			}		},
		appStatus: function(username){
			
			return this.appApi(username,'status',false);			},
		
		components: function(username,action,parameters){

			switch(action){
				case "win10-componentId":

					for(var i = 0; i<this.data.components.length; i++)
					{
						if(username == this.data.components[i].username)
							return i;
					}
					console.log("LINET007: component " + username + ' resolution failed');
					return false;
					break;
				case "win10-mountedState":
					var id = this.components(username,'win10-componentId',false);
					if(!id)
						return false;
					return this.data.components[id].mounted;

					break;
				case "win10-toggleMountedState":

					//console.log('WIN10: toggling ' + username + ' mounted state');
					
					if(this.components(username,"win10-mountedState",false) == false)
						return this.components(username,"win10-componentMount",true);
					
					else
						return this.components(username,"win10-componentMount",false);
					
					
					break;
				case "win10-componentMount":

					var id = this.components(username,'win10-componentId',false);
					
					if(id == false)
						return false;

					if(parameters)
					{
						this.data.components[id].mounted = true;
						$('#'+username).removeClass('hidden');
					}
					else
					{
						this.data.components[id].mounted = false;
						$('#'+username).addClass('hidden');
					}
					
					return true;

					break;				
				case "win10-mount":
					var n = this.username + '-' + username;
					return _components(n,"mount",true);
					break;
				case "win10-applyStyle":
					return _components('win10-application','applyStyle',false);
					break;
				case "win10-newComponent":

					if(parameters == 'default')
					{
						var component = {
							username: username,
							type: parameters,
							mounted: false,
						};

						var id = this.data.components.length;

						this.data.components[id] = component;

						_components(username,"mount",true);

						return true;
					}
					if(parameters == "applyStyle")
						_components(username,"applyStyle",true);

					break;
				case "win10-newComponents":

					for(var i = 0; i<parameters.length; i++)
					{
						var n = (parameters[i] == 'main' ? this.username : this.username + '-' + parameters[i] );
						this.components( n, 'win10-newComponent', 'default');

					}
					return true;

					break;
				default:
					console.log('LINET007: ' + action + ' username: ' + username + ' with ' + parameters );
					return false;
					break;
			}		},
	};
	
	setTimeout(function(){

		_setInstance(_win10);

	},100);


	function checkTime(i){

	    if( i < 10 )
	    {

	        i = "0" + i;

	    }

	    return i;
	}

	function startTime(){

	    var today = new Date();
	    var h = today.getHours();
	    h = (h < 10 ? '0'+h : h);
	    var m = checkTime(today.getMinutes());
	    var x = h + ":" + m + "h";
	    
	    var $launcher = ''+
	    '<p class="launcher-heading">'+
            x+
        '</p>';

	    $('.launcher-heading').remove();
	    $('#win10-launcher').prepend($launcher);

	    t = setTimeout(function(){

	        startTime();
	    },500);
	}

	function runApp(username){
		
		_components('win10-launcher','win10-componentMount',false);	
		_components('win10-notifications','win10-componentMount',false);
		_runApp(username);
	}
	startTime();

});







