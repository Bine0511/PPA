@extends("layout")
@section("content")
	<div class="row">
		<div class="controlpanel col-md-12 col-sm-12 col-xs-12">
			<div id="storybox" class="jumbotron">
				<h3 id="userstory">Das ist eine tolle Userstory</h3>
			</div>
		</div>
	</div>
	<div id="cardbox" class="owl-carousel cardbox-disabled">
		<div class="item item-disabled"><img src="images/0.png" alt="Card 0"></div>
		<div class="item item-disabled"><img src="images/0,5.png" alt="Card 0,5"></div>
		<div class="item item-disabled"><img src="images/1.png" alt="Card 1"></div>
		<div class="item item-disabled"><img src="images/2.png" alt="Card 2"></div>
		<div class="item item-disabled"><img src="images/3.png" alt="Card 3"></div>
		<div class="item item-disabled"><img src="images/5.png" alt="Card 5"></div>
		<div class="item item-disabled"><img src="images/8.png" alt="Card 8"></div>
		<div class="item item-disabled"><img src="images/13.png" alt="Card 13"></div>
		<div class="item item-disabled"><img src="images/20.png" alt="Card 20"></div>
		<div class="item item-disabled"><img src="images/40.png" alt="Card 40"></div>
		<div class="item item-disabled"><img src="images/100.png" alt="Card 100"></div>
		<div class="item item-disabled"><img src="images/coffee.png" alt="Card Coffee"></div>
		<div class="item item-disabled"><img src="images/fragezeichen.png" alt="Card Fragezeichen"></div>
	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
	<script src="js/autobahn.min.js"></script>
	<script type="text/javascript" charset="utf-8">
		var id = '' + Math.floor((Math.random()*1000)+1);
		var sessionid = 'sessions/lobby';
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
			    			case "start":
								$("#cardbox").removeClass('cardbox-disabled');
								$(".item").removeClass('item-disabled');
		    					console.log("enabled");
				        		break;
				        	case "stop":
								$("#cardbox").addClass('cardbox-disabled');
								$(".item").addClass('item-disabled');
		    					console.log("disabled");
								break;
				        	case "again":
				        		break;
			        		default:
			        			break;
		        		}
			            
			        });
			        var message = {};
			        message.user_id = id;
			        message.act = 'join';
		    		console.log("Sending: " + JSON.stringify(message));
			        conn.publish(sessionid, JSON.stringify(message));
			    },
			    function() {
			        var message = {};
			        message.user_id = id;
			        message.act = 'leave';
		    		console.log("Sending: " + JSON.stringify(message));
			        conn.publish(sessionid, JSON.stringify(message));
			    },
			    {
			        // Additional parameters, we're ignoring the WAMP sub-protocol for older browsers
			        'skipSubprotocolCheck': true
			    }
			);
	    	$(".owl-carousel").owlCarousel({
			    margin:10,
			    responsiveClass:true,
			    nav:true,
			    responsive:{
			        0:{
			            items:2
			        },
			        300:{
			        	items:3
			        },
			        600:{
			            items:5
			        },
			        1000:{
			            items:9
			        }
			    }
	    	});

	    	$('.item').click(function(){
				$('.selected').removeClass('selected'); // removes the previous selected class
				$(this).addClass('selected'); // adds the class to the clicked image
		    	var message = {};
		    	message.user_id = id;
		    	message.act = 'pick';
		    	message.val = $(this).children("img").attr('src');
		    	console.log("Sending: " + JSON.stringify(message));
				conn.publish(sessionid, JSON.stringify(message));
			});
		}
	</script>
@stop