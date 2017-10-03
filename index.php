<!DOCTYPE html>
<html>
<head>
<title>Horror Helper</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<link rel="stylesheet" href="www/css/app.css">

</head>

<body>
	<div id="content">
		<div id="image"><img style="max-width: 100%;" id ="poster" src=""/></div>
		<div id="tools">
			<span id="trailer"></span>
		</div>
		<div id="desc">
			<div id="title"></div>
			<span id="overview"></span>
			<span id="release"></span>
			<span id="language"></span>
			<span id="imdb"></span>
		</div>
		<div id="actions">
			<button id="skip_it" class="button">Skip Movie</button>
			<button id="store_it" class="button">Store Movie</button>
			<button id="watched_it" class="button">Watched Movie</button>
		</div>

		<div id="stored" class="movie-container"></div>
		<div id="watched" class="movie-container"></div>
		<div id="skipped" class="movie-container"></div>
	</div>
	<div id="footer">
		<span>Horror Helper 2017</span>
	</div>
</body>

<script type="text/javascript" src="www/js/app.js"></script>
</html>