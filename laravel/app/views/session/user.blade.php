@extends("layout")
@section("content")
	<input type="button" class="button" value="100">
	<div id="users"></div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
	<script src="js/brain-socket.min.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(function(){

			//make sure to update the port number if your ws server is running on a different one.
			window.app = {};

			app.BrainSocket = new BrainSocket(
					new WebSocket('ws://localhost:8080'),
					new BrainSocketPubSub()
			);

			app.BrainSocket.Event.listen('vote.event',function(msg){
				$('#users').append('<div>' + msg.client.data.user_id+' hat abgestimmt: '+msg.client.data.message+'</div>');
			});

			$('.button').click(function(event) {
				app.BrainSocket.message('vote.event',
				{
					'message':$(this).attr('value'),
					'user_id':fake_user_id
				}
				);
			}
			);
		});
	</script>
@stop