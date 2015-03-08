@extends("layout")
@section("content")
	<div class="row">
		<div class="controlpanel col-md-12 col-sm-12 col-xs-12">
			<div id="storybox" class="jumbotron">
				<h3 id="userstory">Das ist eine tolle Userstory</h3>
			</div>
			<div id="controlbox">
				<div class="col-md-3 col-md-offset-3 col-sm-4 col-sm-offset-2 col-xs-12">
				{{ Form::button('Start', array('class' => 'btn btn-lg btn-default btn-block bt_swap bt_start')); }}
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 ">
				{{ Form::button('N&auml;chste User-Story', array('class' => 'btn btn-lg btn-default btn-block bt_next')); }}
				</div>
			</div>
		</div>
	</div>
	<div id="userbox" class="row">
    </div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
	<script src="js/autobahn.min.js"></script>
	<script type="text/javascript" charset="utf-8">
		var id = Math.floor((Math.random()*1000)+1);
		window.onload = function(){
			conn = new ab.Session(
		    	'ws://localhost:8080',
			    function() { // Once the connection has been established
			        conn.subscribe('sessions/lobby', function(topic, msg) {
			        	var message;
			        	if(msg.topic){
			        		message = msg;
		    				console.log("Received Object: " + JSON.stringify(msg));
			        	}else{
			        		message = JSON.parse(msg);
		    				console.log("Received JSON: " + msg);
			        	}

			        	switch(message.act){
			        		case "join":
			        			userid= message.user_id;
			        			$('#userbox').append("<div id='container_" + userid + "' class='boxcontainer col-md-2 col-sm-3 col-xs-6'> \
			        								<div id='box_" + userid + "' class='box'> \
    												<h3><span class='card label label-default'>User" + userid + "</span></h3> \
    												<img id='img_" + userid + "' class='card' src='images/leer.png'/> \
    												</div></div>");
			        			break;
			        		case "pick":
			        			var image_id = '#img_' + message.user_id;
			        			$(image_id).attr("src", message.val);
			        			break;
			        		case "leave":
			        			var container_id = '#container_' + message.user_id;
			        			$(container_id).remove();
			        			break;
			        		default:
			        			break;
			        	}
			        });
			    },
			    function() {
			        // When the connection is closed
			        console.log('WebSocket connection closed');
			    },
			    {
			        // Additional parameters, we're ignoring the WAMP sub-protocol for older browsers
			        'skipSubprotocolCheck': true
			    }
			);

			$(".bt_swap").click(function(){
				var bt_text = $(".bt_swap").text();
		    	var message = {};
		    	message.user_id = id;
				switch(bt_text){
					case "Start":
		    			message.act = 'start';
						$(".bt_swap").html('Stop');
						break;
					case "Stop":
		    			message.act = 'stop';
						$(".bt_swap").html('Wiederholen');
						break;
					case "Wiederholen":
		    			message.act = 'again';
						$(".bt_swap").html('Start');
						break;
				}
		    	console.log("Sending: " + JSON.stringify(message));
				conn.publish('sessions/lobby', JSON.stringify(message));
			});

			$(".bt_stop").click(function(){
				$(this).addClass('bt_again');
				$(this).removeClass('bt_stop');
		    	var message = {};
		    	message.user_id = id;
		    	message.act = 'stop';
		    	console.log("Sending: " + JSON.stringify(message));
				conn.publish('sessions/lobby', JSON.stringify(message));
			});

			$(".bt_again").click(function(){
				$(this).addClass('bt_stop');
				$(this).removeClass('bt_again');
		    	var message = {};
		    	message.user_id = id;
		    	message.act = 'again';
		    	console.log("Sending: " + JSON.stringify(message));
				conn.publish('sessions/lobby', JSON.stringify(message));
			});

			$(".bt_next").click(function(){
				$(".bt_swap").removeClass('bt_start');
				$(".bt_swap").removeClass('bt_stop');
				$(".bt_swap").removeClass('bt_again');
				$(".bt_swap").addClass('bt_stop');
		    	var message = {};
		    	message.user_id = id;
		    	message.act = 'again';
		    	console.log("Sending: " + JSON.stringify(message));
				conn.publish('sessions/lobby', JSON.stringify(message));
			});
		}
	</script>
@stop