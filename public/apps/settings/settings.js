/* @settings */

console.log('@settings script running');

$('#logout').click(function(){
	console.log('@settings: Shutting down Linet');
	_shutdown();
});

$('#reboot').click(function(){
	console.log('@settings: Rebooting Linet');
	_reboot();
	//location.reload();
});