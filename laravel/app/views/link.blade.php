@extends("layout")
@section("content")
<?php
	$sess = 1;
	echo link_to('/pdf/'.$sess, '$title');
?>
@stop
