/* @3cob-beta */ 

console.log('@3cob-beta script running');

//alert('Beta Application');

$('.3cob-contactUsBtn').click(function(){
    $('#3cob-beta').children().children('.application-view').addClass('hidden');
    $('.3cob-beta-contactUs').removeClass('hidden');
});

$('.3cob-requestRideBtn').click(function(){
    $('#3cob-beta').children().children('.application-view').addClass('hidden');
    $('.3cob-beta-requestRide').removeClass('hidden');
});

$('.3cob-homeBtn').click(function(){
    $('#3cob-beta').children().children('.application-view').addClass('hidden');
    $('.3cob-beta-welcome').removeClass('hidden');
});

$('.3cob-faresBtn').click(function(){
    $('#3cob-beta').children().children('.application-view').addClass('hidden');
    $('.3cob-beta-fares').removeClass('hidden');
});

$('.3cob-orderRideBtn').click(function(){
    $('#3cob-beta').children().children('.application-view').addClass('hidden');
    $('.3cob-beta-orderRide').removeClass('hidden');
});