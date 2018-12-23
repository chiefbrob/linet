/* @3cob_drivers */ 

console.log('@3cob_drivers script running');

$('.3cob_drivers-AccountBtn').click(function(){
    $('#3cob_drivers').children().children('.application-view').addClass('hidden');
    $('.3cob_drivers-account').removeClass('hidden');
});

$('.3cob_drivers-HomeBtn').click(function(){
    $('#3cob_drivers').children().children('.application-view').addClass('hidden');
    $('.3cob_drivers-welcome').removeClass('hidden');
});