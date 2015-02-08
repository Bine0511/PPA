@extends("layout")
@section("content")
	<input type="button" class="votebutton" value="0">
	<input type="button" class="votebutton" value="0.5">
	<input type="button" class="votebutton" value="1">
	<input type="button" class="votebutton" value="2">
	<input type="button" class="votebutton" value="3">
	<input type="button" class="votebutton" value="5">
	<input type="button" class="votebutton" value="8">
	<input type="button" class="votebutton" value="13">
	<input type="button" class="votebutton" value="20">
	<input type="button" class="votebutton" value="40">
	<input type="button" class="votebutton" value="100">
	<input type="button" class="votebutton" value="?">
	<input type="button" class="votebutton" value="coffee">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
	<script src="js/brain-socket.min.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(function(){

			//make sure to update the port number if your ws server is running on a different one.
			window.app = {};
			var first = true;
			var fake_user_id = 'User' + (Math.floor((Math.random()*1000)+1)).toString();

			app.BrainSocket = new BrainSocket(
				new WebSocket('ws://localhost:8080'),
				new BrainSocketPubSub()
			);

			app.BrainSocket.Event.listen('pick.event',function(msg){
				$('#users').append('<div>' + msg.client.data.user_id+' hat abgestimmt: '+msg.client.data.message+'</div>');
			});

			window.setTimeout(joinsession, 1000 ); 

			function joinsession(event){
				app.BrainSocket.message('join.event',
				{
					'user_id':fake_user_id,
					'user_name':fake_user_id
				}
				);
			}

			$('.button').click(function(event) {
				app.BrainSocket.message('join.event',
				{
					'message':$(this).attr('value'),
					'user_id':fake_user_id,
					'user_name':fake_user_id
				}
				);
    			$('.button').attr("disabled", "disabled");
    			$('.button').attr("value", "Warten...");
			}
			);
		});
	</script>
@stop