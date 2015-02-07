@extends("layout")
@section("content")
	<div id="users"></div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
	<script src="js/brain-socket.min.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(function(){

			var fake_user_id = Math.floor((Math.random()*1000)+1);

			//make sure to update the port number if your ws server is running on a different one.
			window.app = {};

			app.BrainSocket = new BrainSocket(
					new WebSocket('ws://localhost:8080'),
					new BrainSocketPubSub()
			);

			app.BrainSocket.Event.listen('vote.event',function(msg){
				$('#users').append('<div>' + msg.client.data.user_id+' hat abgestimmt: '+msg.client.data.message+'</div>');
			});

			app.BrainSocket.Event.listen('join.event',function(msg){
				$('#users').append('<div id="' + msg.client.data.user_id + '">' + msg.client.data.user_id+': Waiting... </div>');
			});
		});
	</script>
@stop