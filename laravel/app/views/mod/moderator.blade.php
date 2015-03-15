@extends("layout")
@section("content")
	<div class="row">
		<div class="controlpanel col-md-12 col-sm-12 col-xs-12">
			<div id="storybox" class="jumbotron">
				<h3 id="userstory"></h3>
			</div>
			<div id="controlbox">
				<div class="col-md-3 col-md-offset-3 col-sm-4 col-sm-offset-2 col-xs-12">
				{{ Form::button('Start', array('class' => 'btn btn-lg btn-default btn-block bt_swap bt_start button-disabled')); }}
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 ">
				{{ Form::button('N&auml;chste User-Story', array('class' => 'btn btn-lg btn-default btn-block bt_next button-disabled')); }}
				</div>
			</div>
		</div>
	</div>
	<div id="userbox" class="row">
    </div>
@stop

@section("js")
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
	<script src="js/autobahn.min.js"></script>
	<script type="text/javascript" charset="utf-8">
		var id = Math.floor((Math.random()*1000)+1);
		var sessionid = 'sessions/666';
		window.onload = function(){
			conn = new ab.Session(
		    	'ws://localhost:8080',
			    function() { // Once the connection has been established
			        conn.subscribe(sessionid, function(topic, msg) {
			        	var message;
			        	if(msg.topic){
			        		message = msg;
		    				console.log("Received Object: " + JSON.stringify(msg));
			        	}else{
			        		message = JSON.parse(msg);
		    				console.log("Received JSON: " + msg);
			        	}

			        	switch(message.act){
			        		case "joininfo":
								$(".bt_swap").removeClass('button-disabled');
			        			switch (message.status){
			        				case 0:
										$(".bt_swap").html('Start');
										$(".bt_next").addClass('button-disabled');
			        					break;
			        				case 1:
										$(".bt_swap").html('Stop');
										$(".bt_next").addClass('button-disabled');
			        					break;
			        				case 2:
										$(".bt_swap").html('Wiederholen');
										$(".bt_next").removeClass('button-disabled');
			        					break;
			        				default:
			        					break;;
			        			}
			        			$("#userstory").text(message.story);
			        			break;
			        		case "join":
			        			userid=message.user_id;
			        			$('#userbox').append("<div id='container_" + userid + "' class='boxcontainer col-md-2 col-sm-3 col-xs-6'> \
			        								<div id='box_" + userid + "' class='box'> \
    												<h3><span class='card label label-default'>User" + userid + "</span></h3> \
    												<img id='img_" + userid + "' class='card' src='images/leer.png'/> \
    												</div></div>");
			        			break;
			        		case "prejoin":
			        			userid=message.user_id;
			        			$('#userbox').append("<div id='container_" + userid + "' class='boxcontainer col-md-2 col-sm-3 col-xs-6'> \
			        								<div id='box_" + userid + "' class='box'> \
    												<h3><span class='card label label-default'>User" + userid + "</span></h3> \
    												<img id='img_" + userid + "' class='card' src='images/leer.png'/> \
    												</div></div>");
			        			break;
			        		case "pick":
			        			//change image
			        			var image_id = '#img_' + message.user_id;
			        			$(image_id).attr("src", message.val);
			        			break;
			        		case "leave":
			        			var container_id = '#container_' + message.user_id;
			        			$(container_id).remove();
			        			break;
			        		case "next":
								$(".bt_swap").html('Start');
								$(".bt_next").addClass('button-disabled');
			        			$("#userstory").text(message.story);
			        			$(".card").attr("src","images/leer.png");
			        			break;
			        		default:
			        			break;
			        	}
			        });
			        var message = {};
			        message.user_id = id;
			        message.act = 'modjoin';
		    		console.log("Sending: " + JSON.stringify(message));
			        conn.publish(sessionid, JSON.stringify(message));
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
						$(".bt_next").addClass('button-disabled');
						break;
					case "Stop":
		    			message.act = 'stop';
						$(".bt_swap").html('Wiederholen');
						$(".bt_next").removeClass('button-disabled');
						break;
					case "Wiederholen":
		    			message.act = 'again';
						$(".bt_swap").html('Start');
						$(".bt_next").addClass('button-disabled');
			        	$(".card").attr("src","images/leer.png");
						break;
				}
		    	console.log("Sending: " + JSON.stringify(message));
				conn.publish(sessionid, JSON.stringify(message));
			});

			$(".bt_next").click(function(){
				$(".bt_next").addClass('button-disabled');
				$(".bt_swap").html('Start');
		    	var message = {};
		    	message.user_id = id;
		    	message.act = 'next';
		    	console.log("Sending: " + JSON.stringify(message));
				conn.publish(sessionid, JSON.stringify(message));
			});
		}
	</script>
@stop