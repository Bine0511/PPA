@extends("layout")
@section("content")
	{{ HTML::style('css/session.css'); }}
	
	<div id ="story">
	</div>

	<table id="users">
  	<tr>
    	<th>Karte</th>
    	<th>User</th>
  	</tr>
	</table>
	<div id="buttonset">
		<input class="controlbutton" id="bt_next_story" type="button" value="Nächste Story">
		<input class="controlbutton" id="bt_repeat_story" type="button" value="Story wiederholen">
		<input class="controlbutton" id="bt_startstop" type="button" value="Start">
	</div>
	<input type="button" class="button" value="Start">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
	<script src="js/brain-socket.min.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(function(){

			var fake_user_id = Math.floor((Math.random()*2000)+1);

			//make sure to update the port number if your ws server is running on a different one.
			window.app = {};

			var found = false;

			app.BrainSocket = new BrainSocket(
					new WebSocket('ws://localhost:8080'),
					new BrainSocketPubSub()
			);

			/*$('#bt_startstop').click(function(event) {
				if(this.attr('value').equals('Start')){

				}
				app.BrainSocket.message('insert.vote',
				{
					'user': [
					$('.display_user').each(function() {
	    				'id':$(this).children();
						'name':fake_user_id,
						'value':$(this).children('.card').attr('src').
					});
					]
				});
			});*/

			app.BrainSocket.Event.listen('join.event',function(msg){
				$('.display_user').each(function() {
    				if(!(this.id.split("_")[1].equals(msg.client.data.user_id.toString()))){
    					found = true;
    				}
				});
				if(!found){
					$('#users').append('<tr class ="display_user" id="tr_' + msg.client.data.user_id + '"><td><img class="card" src="images/leer.png"></td><td>' + msg.client.data.user_name+'</td></tr>');

				}
			});

			app.BrainSocket.Event.listen('pick.event',function(msg){
				$('#tr_' + msg.client.data.user_id).replaceWith('<tr id="tr_' + msg.client.data.user_id +'"><td><img class="card"src="images/' + msg.client.data.value + '.png">'+ msg.client.data.value +'</img></td><td>' + msg.client.data.user_name+'</td></tr>');
			});
		});
	</script>
@stop