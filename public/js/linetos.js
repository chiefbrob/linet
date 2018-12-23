/* LINET CLIENT */

$().ready(function(){

	console.log('LUGHA YETU NETWORK');

	var _linet = {

		id: false,
		username: $('body').attr('username'),
		os: false,
		status: "initializing",
		token: $('#logout-form').children('input:first').attr('value'),
		data: false,

		boot: function(username){
			//FIRST CODE THAT RUNS
			var scriptName = 'os+' + username;
			this.loadScript(scriptName); 	},
		setInstance: function($instance){
			if(this.os)
				return "LINET003"; //CLIENT OS EXISTS
			this.os = $instance;
			return this.os.boot();		},
		reboot: function(){
			this.os.reboot();
			this.sync();
			location.reload();		},
		shutdown: function(){
			this.os.shutdown();
			this.sync();
			$('#logout-form').submit();		},
		sync: function(){
			//upload unsaved data
			//LINET004 - SYNC FAILED
			console.log('LINET: Data save success');		},
		getStatus: function(){

			return this.status;		},
		getToken: function(){

			return this.token;		},
		api: function(endPoint,action,parameters){

			switch(endPoint){

				default:
					if(!this.os)
						return this.os.api(endPoint,action,parameters);
					return "LINET002"; //CLIENT OS MISSING
					break;

			}	},

		components: function(username,action,parameters){
			
			switch(action){

				case "mount":
					//console.log('LINET: mounting ' + username);
					this.mountHtml('os+' + username);

					if(parameters)
						this.applyStyle('os+'+username);

					break;
				case "unmount":

					this.unmountHtml(username);

					this.removeStyle(username);


					break;
				case "applyStyle":

					//console.log('LINET: applying style ' + username);
					this.applyStyle('os+'+username);

					break;
				case "removeStyle":
					this.removeStyle('os+'+username);
					break;
				case "status":

					break;
				default:
					return this.os.components(username,action,parameters);
					break;
			}		},
		mountHtml: function(username){

			var component = username + '.html';
			//console.log('LINET: mounting html >> ' + component);


			$.ajax({
				type: 'POST',
				url: 'system/' + component,
				data: {_token: _getToken(), username: username },
				success: function(component) {
					//console.log('LINET: ' + username + '.html mounted');
					$('body').append(component);
					
				},
				error: function() {
					
					console.log('LINET: Failed to mount component');
				},
			});		},
		unmountHtml: function(username){
			//console.log('LINET: unmounting html >> ' + component + '.html');
			$('#'+username).remove();		},
		loadScript: function(name){

			console.log('LINET: loading script >> ' + name + '.js');

			$.ajax({
				type: 'POST',
				url: 'system/' + name + '.js/',
				data: {_token: _getToken(), },
				success: function(script) {

					_interpret(script);
				},
				error: function() {
					
					console.log('LINET: failed to fetch and execute script');
				},
			});		},
		interpret: function(code){
			
			eval(code);		},
		applyStyle: function(name){

			//console.log('LINET: applying style >> ' + name + '.css');

			$("<link/>", {
				id: name + '-style',
				rel: "stylesheet",
				type: "text/css",
				href: "style/" + name + '.css/',
			}).appendTo("head");		},
		removeStyle: function(name){
			//console.log('LINET: removing style >> ' + name + '.css');

			$('#' + name+'-style').remove();		},

		makeApp: function(username){
			//makes an application for linet client
			return {
				username: username,
				status: 'initializing',
				data: false,

				boot: function(focus){

					console.log('LINET: @' + username + ' booting');

					//_initialize(this.username);
					_mountHtml(this.username);
					_applyStyle(this.username);
					//setTimeout(_loadScript,1000,this.username);
					_loadScript(this.username);

					return _appApi(this.username,'run',focus); },
				shutdown: function(){
					//_appApi(this.username,'shutdown',false);
					_unmountHtml(this.username);
					_removeStyle(this.username);
					//_interpret(this.username + 'Close();');
					return true;				},
				getStatus: function(){

					return this.status;				},

			};	},
		installApp: function(username){

			return this.os.installApp(username);	},
		appStatus: function(username){

			return this.os.appApi(username,'status',false);		},
		uninstallApp: function(username){

			return this.os.uninstallApp(username);	},
		runApp: function(username){

			this.os.runApp(username);		},
		stopApp: function(username){

			this.os.stopApp(username);		},
		appApi: function(username,action,parameters){
			
			return this.os.appApi(username,action,parameters);		},
	};
	

	
//SYSTEM
	function _boot(username){
		//Every OS has a unique username
		//Starts interface
		return _linet.boot(username);	}
	function _setInstance($instance){
		//Attachs an OS instance to the client
		return _linet.setInstance($instance);	}
	function _reboot(){
		//starts a fresh
		return _linet.reboot();	}
	function _shutdown(){
		//save and exit
		return _linet.shutdown();	}
	function _sync(){

		return _linet.sync();	}
	function _getStatus(){

		return _linet.getStatus();	}
	function _getToken(){

		return _linet.getToken();	}
	function _api(endPoint, action, parameters){

		return _linet.api( endPoint, action, parameters);	}

	function _components(username,action,parameters){
		//API FOR COMPONENTS
		_linet.components(username,action,parameters);	}
	function _mountHtml(username){
		//
		return _linet.mountHtml(username);	}
	function _unmountHtml(username){
		//
		return _linet.unmountHtml(username);	}
	function _loadScript(name){
		//All script files have a unique name
		//gets a script from server and evaluates it
		return _linet.loadScript(name);	}
	function _interpret(code){
		//using eval
		return _linet.interpret(code);	}
	function _applyStyle(name){
		//All style files have unique names
		//applies styling to page
		return _linet.applyStyle(name);	}
	function _removeStyle(name){
		//All style files have unique names
		//removes styling from page
		return _linet.removeStyle(name);	}
	
	




//APPLICATIONS
	function _makeApp(username){
		//Makes a linet application for OS
		return _linet.makeApp(username);	}
	function _installApp(username){
		//Every application has a unique username
		//will install the application and notify os 
		return _linet.installApp(username);	}
	function _appStatus(username){
		//returns true if installed, false otherwise
		return _linet.appStatus(username);	}
	function _uninstallApp(username){
		//Every application has a unique username
		//will uninstall the application and notify os 
		return _linet.uninstallApp(username);	}
	function _runApp(username){
		//runs an application
		return _linet.runApp(username);	}
	function _stopApp(username){
		//stops a running application
		return _linet.stopApp(username);	}
	function _appApi(username,action,parameters){
		//will command an app to do an action
		return _linet.appApi(username,action,parameters);	}
	function _firstApp(){

		return $('body').attr('firstApp');	}
	function _appIcon(username){
		
		return username;}


//USER 
	function username(){
		return _linet.username;
	}






	var template = $('body').attr('template');
	_boot(template);


});

/*
	@LUGHA YETU
*/