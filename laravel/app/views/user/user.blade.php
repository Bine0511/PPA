@extends("layout")
@section("content")
	<div class="row">
		<div class="controlpanel col-md-12 col-sm-12 col-xs-12">
			<div id="storybox" class="jumbotron" data-toggle="modal" data-target="#storymodal">
				<h3 id="userstory"></h3>
			</div>
			<!-- Modal -->
		</div>
	</div>
	<div id="basebox" class="row">
		<div class="basepanel col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-12">
			{{ Form::button('Basisstory anzeigen', array('class' => 'btn btn-lg btn-default btn-block bt_swap bt_start', 'data-toggle' => 'modal', 'data-target' => '#basemodal')); }}
		</div>
	</div>
	<div class="row">
		<div class="controlpanel col-md-12 col-sm-12 col-xs-12">
			<h3 id="statusmessage">Warten auf Moderator....</h3>
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
	<div id="timebox" class="row">
		<div class="controlpanel col-md-12 col-sm-12 col-xs-12">
			<h2>Bitte in Stunden sch&auml;tzen!</h2>
		</div>
		<div class="controlpanel col-md-2 col-md-offset-5 col-sm-4 col-sm-offset-4 col-xs-6 col-xs-offset-3">
			{{ Form::text('description', null, array('id' => 'timeinput', 'class' => 'form-control signin-input')) }}
		</div>
	</div>
	<div id="userbox" class="row">
    </div>
@stop

@section("js")
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
	<script src="js/autobahn.min.js"></script>
	<script src="packages/owlcarousel/owl.carousel.js"></script>
	<script type="text/javascript" charset="utf-8">
		@if (Auth::User()->check())
	        var name = "{{ Auth::User()->get()->user_name }}";
	        var id = "{{ Auth::User()->get()->user_ID }}";
	        var sessionid = {{ Auth::User()->get()->user_session_ID }};
	    @endif
		var sessionstring = 'sessions/' + sessionid;
		$("#timebox").hide();
		window.onload = function(){
			conn = new ab.Session(
		    	'ws://10.3.59.11:8080',
			    function() { // Once the connection has been established
			        conn.subscribe(sessionstring, function(topic, msg) {
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
			        			if(message.mode=="norm"){
			        				$("#baselabel").text(message.basestory);
			        				$("#basedesc").text(message.basedesc);
				        			switch (message.status){
				        				case 0:
				         					$("#cardbox").addClass('cardbox-disabled');
											$(".item").addClass('item-disabled');
			    							$("#statusmessage").text("Warten auf Moderator...");
											$("#cardbox").show();
											$("#userbox").hide();
				        					break;
				        				case 1:
											$("#cardbox").removeClass('cardbox-disabled');
											$(".item").removeClass('item-disabled');
					    					$("#statusmessage").text("Abstimmen!");
											$("#cardbox").show();
											$("#userbox").hide();
				        					break;
				        				case 2:
				        					$("#cardbox").addClass('cardbox-disabled');
											$(".item").addClass('item-disabled');
					    					$("#statusmessage").text("Moderator hat die Kartenauswahl gesperrt");	
											$("#cardbox").show();
											$("#userbox").hide();
				        					break;
				        				default:
				        					break;;
				        			}
				        		}
				        		if(message.mode == "time"){
				        			$("#basebox").hide();
				        			switch (message.status){
				        				case 0:
											$("#cardbox").hide();
											$("#timeinput").prop('disabled', true);
			    							$("#statusmessage").text("Warten auf Moderator...");
											$("#timebox").show();
											$("#userbox").hide();
				        					break;
				        				case 1:
											$("#cardbox").hide();
											$("#timeinput").prop('disabled', false);
					    					$("#statusmessage").text("Abstimmen!");
											$("#timebox").show();
											$("#userbox").hide();
				        					break;
				        				case 2:
											$("#cardbox").hide();
											$("#timeinput").prop('disabled', true);
					    					$("#statusmessage").text("Moderator hat die Kartenauswahl gesperrt");	
											$("#timebox").show();
											$("#userbox").hide();
				        					break;
				        				default:
				        					break;;
				        			}
				        		}
			        			$("#userstory").text(message.story);
			        			$("#storyheader").text(message.story);
			        			$("#storydesc").text(message.desc);
			        			break;
			    			case "start":
								$("#cardbox").removeClass('cardbox-disabled');
								$(".item").removeClass('item-disabled');
		    					$("#statusmessage").text("Abstimmen!");
								$("#cardbox").show();
								$("#userbox").hide();
				        		break;
				        	case "stop":
								$("#cardbox").addClass('cardbox-disabled');
								$(".item").addClass('item-disabled');
		    					$("#statusmessage").text("Moderator hat die Kartenauswahl gesperrt");
								$("#cardbox").hide();
								$("#userbox").show();
								break;
							case "timestart":
								$("#timeinput").prop('disabled', false);
		    					$("#statusmessage").text("Abstimmen!");
								$("#timebox").show();
								$("#userbox").hide();
								break;
							case "timestop":
								$("#statusmessage").text("Moderator hat die Kartenauswahl gesperrt");
								$("#timeinput").prop('disabled', true);
								$("#timebox").hide();
								$("#userbox").show();
		    					$('#timeinput').val('');
								break;
							case "timeagain":
								$("#timeinput").prop('disabled', true);
								$("#timebox").show();
								$("#userbox").hide();
								$("#userbox").empty();
								break;
							case "voteinfo":
			        			var userid = message.user_id;
			        			var username = message.user_name;
			        			var value = message.val;
			        			var labelclass ="label-default";
			        			var text = username;
			        			if(username == name){
			        				labelclass = "label-danger";
			        				text = "Ich";
			        			}
			        			$('#userbox').append("<div id='container_" + userid + "' class='boxcontainer col-md-2 col-sm-3 col-xs-6'> \
			        								<div id='box_" + userid + "' class='box'> \
    												<h3><span class='card label " + labelclass + "'>" + text + "</span></h3> \
    												<img id='img_" + userid + "' class='card' src='images/" + value + ".png'/> \
    												</div></div>");
			        			break;
			        		case "timevoteinfo":
			        			var userid = message.user_id;
			        			var username = message.user_name;
			        			var value = message.val;
			        			var labelclass ="label-default";
			        			var text = username;
			        			if(username == name){
			        				labelclass = "label-danger";
			        				text = "Ich";
			        			}
			        			$('#userbox').append("<div id='container_" + userid + "' class='boxcontainer col-md-2 col-sm-3 col-xs-6'> \
			        								<div id='box_" + userid + "' class='box'> \
    												<h3><span class='card label " + labelclass + "'>" + text + "</span></h3> \
    												<span id='vote_" + userid + "' class='card timecard'>" + value + " h<span/> \
    												</div></div>");
			        			break;
				        	case "again":
								$('.selected').removeClass('selected');
				        		$("#cardbox").addClass('cardbox-disabled');
								$(".item").addClass('item-disabled');
		    					$("#statusmessage").text("Warten auf Moderator...");
								$("#cardbox").show();
								$("#userbox").hide();
								$("#userbox").empty();
				        		break;
				        	case "next":
								$('.selected').removeClass('selected');
				        		$("#cardbox").addClass('cardbox-disabled');
								$(".item").addClass('item-disabled');
		    					$("#statusmessage").text("Warten auf Moderator...");
								$("#cardbox").show();
								$("#userbox").hide();
								$("#userbox").empty();
			        			$("#userstory").text(message.story);
			        			$("#storyheader").text(message.story);
			        			$("#storydesc").text(message.desc);
			        			break;
			        		case "timenext":
				        		$("#basebox").hide();
		    					$("#statusmessage").text("Warten auf Moderator...");
								$("#timeinput").prop('disabled', true);
								$("#userbox").hide();
								$("#timebox").hide();
								$("#userbox").empty();
			        			$("#userstory").text(message.story);
			        			$("#storyheader").text(message.story);
			        			$("#storydesc").text(message.desc);
			        			break;
			        		case "ende":
			        			window.location="{{URL::to('end')}}";
			        		default:
			        			break;
		        		}
			        });
			        var message = {};
			        message.user_id = id;
			        message.user_name = name;
			        message.act = 'join';
		    		console.log("Sending: " + JSON.stringify(message));
			        conn.publish(sessionstring, JSON.stringify(message));
			    },
			    function() {
			        var message = {};
			        message.user_id = id;
			        message.user_name = name;
			        message.act = 'leave';
		    		console.log("Sending: " + JSON.stringify(message));
			        conn.publish(sessionstring, JSON.stringify(message));
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
		    	message.user_name = name;
		    	message.act = 'pick';
		    	message.val = $(this).children("img").attr('src');
		    	console.log("Sending: " + JSON.stringify(message));
				conn.publish(sessionstring, JSON.stringify(message));
			});

			$("#timeinput").on("input", function() {
				var message = {};
					message.user_id = id;
				message.user_name = name;
				message.act = 'pick';
				message.val = $('#timeinput').val();
				console.log("Sending: " + JSON.stringify(message));
				conn.publish(sessionstring, JSON.stringify(message));
			});
		}
	</script>
@stop