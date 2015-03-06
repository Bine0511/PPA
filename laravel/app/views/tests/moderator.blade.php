@extends("layout")
@section("content")
	<div class="row">
		<div class="controlpanel col-md-12 col-sm-12 col-xs-12">
			<div id="storybox" class="jumbotron">
				<h3 id="userstory">Das ist eine tolle Userstory</h3>
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
			        	console.log(msg);
			        	var message = JSON.parse(msg);
			        	console.log(message.act);
			        	switch(message.act){
			        		case "join":
			        			$('#userbox').append("<div class='boxcontainer col-md-2 col-sm-3 col-xs-6'> \
			        								<div class='box'> \
    												<h3><span class='card label label-default'>Testuser</span></h3> \
    												<img class='card' src='images/leer.png'/> \
    												</div></div>");
			        			break;
			        		case "leave":
			        			$('#userbox').
			        		default:
			        			break;
			        	}
			            console.log(JSON.parse(msg.user_id)); 
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
		}
	</script>
@stop