<!DOCTYPE html>
<html>
<head>
<title>Horror Helper</title>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<link rel="stylesheet" href="www/css/app.css">
</head>

<body>
	<div id="content">
		<div id="image"><img style="max-width: 100%;" id ="poster" src=""/></div>
		<div id="tools">
			<span id="trailer"></span>
			<div id="search_conditions"></div>
			<div id="watch_counts"></div>
		</div>
		<div id="desc">
			<div id="title"></div>
			<span id="overview"></span>
			<span id="release"></span>
			<span id="runtime"></span>
			<span id="imdb"></span>
			<span id="language"></span>
		</div>
		<div id="actions">
			<button id="skip_it" class="button">Skip Movie</button>
			<button id="store_it" class="button">Store Movie</button>
			<button id="watched_it" class="button">Watched Movie</button>
		</div>

		<div id="stored" class="movie-container"><h2>Stored Movies</h2><span></span></div>
		<div id="watched" class="movie-container"><h2>Watched Movies</h2><span></span></div>
		<div id="skipped" class="movie-container"><h2>Skipped Movies</h2><span></span></div>
	</div>
	<div id="footer">
		<span>Horror Helper 2017</span>
	</div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="www/js/app.js"></script>
</html>