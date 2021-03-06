@extends("layout")
@section("content")
	<div id="head" class="row">
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

    <div id="timebox" class="row">
		<div class="controlpanel col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
	    	<h2>W&auml;hlen Sie die 3 Storys f&uuml;r die Zeitsch&auml;tzung!</h2>
	    	<select id="SEL_1" class="sel form-control">
	    	</select>
	    	<select id="SEL_2" class="sel form-control">
	    	</select>
	    	<select id="SEL_3" class="sel form-control">
	    	</select>
	    	{{ Form::button('Los!', array('class' => 'btn btn-lg btn-danger btn-block', 'id' => 'bt_time')) }}
    	</div>
    </div>
@stop

@section("js")
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
	<script src="js/autobahn.min.js"></script>
	<script type="text/javascript" charset="utf-8">
		@if (Auth::Mod()->check())
	        @if(Auth::PPSession()->check())
	        var id = "{{ Auth::Mod()->get()->moderator_ID }}";
	        var sessionid = {{ Auth::PPSession()->get()->session_ID }};
	        @endif
	    @endif
		var sessionstring = 'sessions/' + sessionid;
		var mode = "norm";
		$("#timebox").hide();
		window.onload = function(){
			conn = new ab.Session(
		    	'ws://localhost:8080',
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
								$(".bt_swap").removeClass('button-disabled');
								mode = message.mode;
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
			        				case 3:
			        					$("#head").hide();
					        			$("#userbox").hide();
					        			$("#timebox").show();
					        			var stories = message.stories;
					        			var key;
										for (key in stories) {
											$('#SEL_1').append("<option id='opt_" + stories[key].userstory_ID + "'>" + stories[key].userstory_name + "</option>");
											$('#SEL_2').append("<option id='opt_" + stories[key].userstory_ID + "'>" + stories[key].userstory_name + "</option>");
											$('#SEL_3').append("<option id='opt_" + stories[key].userstory_ID + "'>" + stories[key].userstory_name + "</option>");
										}
			        				default:
			        					break;;
			        			}
			        			$("#userstory").text(message.story);
			        			$("#storyheader").text(message.story);
			        			$("#storydesc").text(message.desc);
			        			break;
			        		case "join":
			        			userid=message.user_id;
			        			username=message.user_name;
			        			$('#container_' + userid).remove();
			        			if(mode=="time"){
			        				$('#userbox').append("<div id='container_" + userid + "' class='boxcontainer col-md-2 col-sm-3 col-xs-6'> \
			        								<div id='box_" + userid + "' class='box'> \
    												<h3><span class='card label label-default'>" + username + "</span></h3> \
    												<span id='vote_" + userid + "' class='card timecard'> </span> \
    												</div></div>");
			        			}else{
			        				$('#userbox').append("<div id='container_" + userid + "' class='boxcontainer col-md-2 col-sm-3 col-xs-6'> \
			        								<div id='box_" + userid + "' class='box'> \
    												<h3><span class='card label label-default'>" + username + "</span></h3> \
    												<img id='img_" + userid + "' class='card' src='images/leer.png'/> \
    												</div></div>");
			        			}
			        			break;
			        		case "prejoin":
			        			userid=message.user_id;
			        			username=message.user_name;
			        			$('#container_' + userid).remove();
			        			if(mode=="time"){
			        				$('#userbox').append("<div id='container_" + userid + "' class='boxcontainer col-md-2 col-sm-3 col-xs-6'> \
			        								<div id='box_" + userid + "' class='box'> \
    												<h3><span class='card label label-default'>" + username + "</span></h3> \
    												<span id='vote_" + userid + "' class='card timecard'> </span> \
    												</div></div>");
			        			}else{
			        				$('#userbox').append("<div id='container_" + userid + "' class='boxcontainer col-md-2 col-sm-3 col-xs-6'> \
			        								<div id='box_" + userid + "' class='box'> \
    												<h3><span class='card label label-default'>" + username + "</span></h3> \
    												<img id='img_" + userid + "' class='card' src='images/leer.png'/> \
    												</div></div>");
			        			}
			        			break;
			        		case "pick":
			        			if(mode=="time"){
			        				var span_id = '#vote_' + message.user_id;
			        				$(span_id).text(message.val + " h");
			        			}else{
			        				//change image
			        				var image_id = '#img_' + message.user_id;
			        				$(image_id).attr("src", message.val);
			        			}
			        			break;
			        		case "leave":
			        			var container_id = '#container_' + message.user_id;
			        			$(container_id).remove();
			        			break;
			        		case "next":
								$(".bt_swap").html('Start');
								$(".bt_next").addClass('button-disabled');
			        			$("#userstory").text(message.story);
			        			$("#storyheader").text(message.story);
			        			$("#storydesc").text(message.desc);
			        			$(".card").attr("src","images/leer.png");
			        			break;
			        		case "time":
			        			$("#head").hide();
			        			$("#userbox").hide();
			        			$("#timebox").show();
			        			mode="time";
			        			var stories = message.stories;
			        			var key;
								for (key in stories) {
									$('#SEL_1').append("<option id='opt_" + stories[key].userstory_ID + "'>" + stories[key].userstory_name + "</option>");
									$('#SEL_2').append("<option id='opt_" + stories[key].userstory_ID + "'>" + stories[key].userstory_name + "</option>");
									$('#SEL_3').append("<option id='opt_" + stories[key].userstory_ID + "'>" + stories[key].userstory_name + "</option>");
								}
			        			break;
			        		case "timenext":
			        			$(".bt_swap").html('Start');
								$(".bt_next").addClass('button-disabled');
			        			$("#userstory").text(message.story);
			        			$("#storyheader").text(message.story);
			        			$("#storydesc").text(message.desc);
			        			$(".timecard").text('');
			        			break;

			        		case "ende":
			        			window.location="{{URL::to('pdf/" + sessionid + "')}}";
			        		default:
			        			break;
			        	}
			        });
			        var message = {};
			        message.user_id = id;
			        message.act = 'modjoin';
		    		console.log("Sending: " + JSON.stringify(message));
			        conn.publish(sessionstring, JSON.stringify(message));
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
				conn.publish(sessionstring, JSON.stringify(message));
			});

			$(".bt_next").click(function(){
				$(".bt_next").addClass('button-disabled');
				$(".bt_swap").html('Start');
		    	var message = {};
		    	message.user_id = id;
		    	message.act = 'next';
		    	console.log("Sending: " + JSON.stringify(message));
				conn.publish(sessionstring, JSON.stringify(message));
			});

			$("#bt_time").click(function(){
		        var message = {};
		        message.user_id = id;
		        message.act = 'timechosen';
		        message.storyid = $( "#SEL_1 option:selected" ).attr('id').split('_')[1];
	    		console.log("Sending: " + JSON.stringify(message));
		        conn.publish(sessionstring, JSON.stringify(message));


		        var message = {};
		        message.user_id = id;
		        message.act = 'timechosen';
		        message.storyid = $( "#SEL_2 option:selected" ).attr('id').split('_')[1];
	    		console.log("Sending: " + JSON.stringify(message));
		        conn.publish(sessionstring, JSON.stringify(message));


		        var message = {};
		        message.user_id = id;
		        message.act = 'timechosen';
		        message.storyid = $( "#SEL_3 option:selected" ).attr('id').split('_')[1];
	    		console.log("Sending: " + JSON.stringify(message));
		        conn.publish(sessionstring, JSON.stringify(message));

		        var message = {};
		        message.user_id = id;
		        message.act = 'timefwd';
	    		console.log("Sending: " + JSON.stringify(message));
		        conn.publish(sessionstring, JSON.stringify(message));
		        $("#userbox").empty();
		        $("#head").show();
			    $("#userbox").show();
			    $("#timebox").hide();
			});
		}
	</script>
@stop