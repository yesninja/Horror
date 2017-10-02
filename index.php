<!DOCTYPE html>
<html>
<head>
<title>Horror Helper</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>
	<div id="content">
		<dic id="title"></div>
		<div id="image"></div>
		<div id="tools">
			<span id="trailer"></span>
			<span id="imdb"></span>
		</div>
		<div id="desc">
			<span id="overview"></span>
			<span id="release"></span>
			<span id="language"></span>
		</div>

		<div id="actions">
			<button>Skip Movie</button>
			<button>Watched Movie</button>
		</div>

		<div id="watched"></div>
		<div id="skipped"></div>
	<div>
	<div id="footer">
		<span>Horror Helper 2017</span>
</body>

<script type="text/javascript" src="www/js/app.js"></script>

<script type="text/javascript">

$( document ).ready(function() {
	var app_url = "app.php";
	data = {
		"c":"Movie",
		"m":"GetCurrentMovie"
	};

	$.post( app_url, data)
	  .done(function( data ) {
	    alert( "Data Loaded: " + data );
	  });
});

</script>
</html>

