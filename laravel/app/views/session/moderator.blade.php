@extends("layout")
@section("content")
	{{ HTML::style('css/session.css'); }}
	
	<table id="users">
  	<tr>
    	<th>Karte</th>
    	<th>User</th>
  	</tr>
	</table> 
	<input type="button" class="button" value="Start">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
	<script src="js/brain-socket.min.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(function(){

			var fake_user_id = Math.floor((Math.random()*2000)+1);

			//make sure to update the port number if your ws server is running on a different one.
			window.app = {};

			app.BrainSocket = new BrainSocket(
					new WebSocket('ws://localhost:8080'),
					new BrainSocketPubSub()
			);

			app.BrainSocket.Event.listen('join.event',function(msg){
				$('#users').append('<tr id="tr_' + msg.client.data.user_id +'"><td><img class="card" src="images/leer.png"></td><td>' + msg.client.data.user_name+'</td></tr>');
			});

			app.BrainSocket.Event.listen('pick.event',function(msg){
				$('#tr_' + msg.client.data.user_id).replaceWith('<tr id="tr_' + msg.client.data.user_id +'"><td><img class="card"src="images/' + msg.client.data.value + '.png"></td><td>' + msg.client.data.user_name+'</td></tr>');
			});
		});
	</script>
@stop