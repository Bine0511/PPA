<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Bootstrap Core CSS -->

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<!-- Custom CSS -->
<link href="css/index.css" rel="stylesheet">
<link rel="shortcut icon" href="images/PPA_Logo-800-500.png" type="image/x-icon" />


<title>Planning Poker App</title>

<!--Carousel-->
<link rel="stylesheet" href="packages/owlcarousel/assets/owl.carousel.css">
<link rel="stylesheet" href="packages/owlcarousel/assets/owl.theme.default.css">

<style type="text/css">
   .dock img { behavior: url(iepngfix.htc) }
  </style>
</head>
<body>
	<div class="modal fade" id="descModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 	<div class="modal-dialog">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title" id="myModalLabel">Userstory Beschreibung</h4>
	      		</div>
	      		<div class="modal-body">
	        	<span id="us_desc">Beschreibung</span>
	      		</div>
	      		<div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      		</div>
	    	</div>
	  	</div>
	</div>
	@include("header")
	<div class="container-fluid theme-showcase" role="main">
		@yield("content")
	</div>
	@include("footer")
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<script src="packages/owlcarousel/owl.carousel.js"></script>
	@yield("js")
</body>
</html>