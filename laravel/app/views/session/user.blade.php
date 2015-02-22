@extends("layout")
@section("content")
	{{ HTML::style('css/session.css'); }}

	<div id="voter">
		<input type="button" class="votebutton" value="0" style="background-image: url('images/0.png')">
		<input type="button" class="votebutton" value="0,5" style="background-image: url('images/0,5.png')">
		<input type="button" class="votebutton" value="1" style="background-image: url('images/1.png')">
		<input type="button" class="votebutton" value="2" style="background-image: url('images/2.png')">
		<input type="button" class="votebutton" value="3" style="background-image: url('images/3.png')">
		<input type="button" class="votebutton" value="5" style="background-image: url('images/5.png')">
		<input type="button" class="votebutton" value="8" style="background-image: url('images/8.png')">
		<input type="button" class="votebutton" value="13" style="background-image: url('images/13.png')">
		<input type="button" class="votebutton" value="20" style="background-image: url('images/20.png')">
		<input type="button" class="votebutton" value="40" style="background-image: url('images/40.png')">
		<input type="button" class="votebutton" value="100" style="background-image: url('images/100.png')">
		<input type="button" class="votebutton" value="fragezeichen" style="background-image: url('images/fragezeichen.png')">
		<input type="button" class="votebutton" value="coffee" style="background-image: url('images/coffee.png')">
	</div>

	<div id="viewer">
		<table id="users">
	  		<tr>
	    		<th>Karte</th>
	    		<th>User</th>
	  		</tr>
		</table>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
	<script src="js/brain-socket.min.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(function(){

			window.app = {};
			var first = true;
			var fake_user_id = 12; //Math.floor((Math.random()*1000)+1);
			var fake_user_name = 'User' + fake_user_id.toString();
			$('#viewer').css( "display", "none" );

			app.BrainSocket = new BrainSocket(
				new WebSocket('ws://localhost:8080'),
				new BrainSocketPubSub()
			);

			window.setTimeout(joinsession, 2000 ); 

			$('.votebutton').click(function(event) {
				app.BrainSocket.message('pick.event',
				{
					'user_id':fake_user_id,
					'user_name':fake_user_name,
					'value':$(this).attr('value')
				}
				);
			}
			);

			function joinsession(event){
				app.BrainSocket.message('join.event',
				{
					'user_id':fake_user_id,
					'user_name':fake_user_name
				}
				);
			}

			app.BrainSocket.Event.listen('insert.vote',function(msg){
				
			});

		});
	</script>
@stop