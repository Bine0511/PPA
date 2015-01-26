<?php

// Default Events
Event::listen('generic.event',function($client_data){
    return BrainSocket::message('generic.event',array('message'=>'A message from a generic event fired in Laravel!'));
});

Event::listen('app.success',function($client_data){
    return BrainSocket::success(array('There was a Laravel App Success Event!'));
});

Event::listen('app.error',function($client_data){
    return BrainSocket::error(array('There was a Laravel App Error!'));
});


//Selfmade Events
Event::listen('vote.event',function($client_data){
    return BrainSocket::message('vote.event',array('message'=>'A User voted!'));
});

Event::listen('join.event',function($client_data){
    return BrainSocket::message('join.event',array('message'=>'A User joined the room!'));
});

Event::listen('story.event',function($client_data){
    return BrainSocket::message('story.event',array('message'=>'The next story is coming!'));
});

?>