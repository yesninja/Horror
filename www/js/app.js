var app_url = "app.php";

$( document ).ready(function() {
	
	var data = {
		"c":"Movie",
		"m":"getCurrentMovie"
	};

	if (window.location.pathname == "/horror/")
	{
		$.post( app_url, data)
		  .done(function( data ) {
		    displayMovie(data);
		});
	}

	// Clicks...
	$( "#watched_it" ).on("click", function() {
		var data = {
			"c":"Movie",
			"m":"getNextMovie",
			"watched":true
		};

		$.post( app_url, data)
		  .done(function( data ) {
		    displayMovie(data);
		});		  
	});

	$( "#skip_it" ).on("click", function() {
		var data = {
			"c":"Movie",
			"m":"getNextMovie",
			"skip":true
		};
		
		$.post( app_url, data)
		  .done(function( data ) {
			displayMovie(data);
		});		  
	});

	$( "#store_it" ).on("click", function() {
		var data = {
			"c":"Movie",
			"m":"getNextMovie",
			"store":true
		};
		
		$.post( app_url, data)
		  .done(function( data ) {
			displayMovie(data);
		});		  
	});

	$( "#login_form" ).submit(function( event ) {
	  	event.preventDefault();
		var data = {
			"c":"Login",
			"m":"login",
			"username": $( "#username" ).val(),
			"password": $( "#password" ).val(),
		};

		$.post( app_url, data)
		  .done(function( data ) {
			if (data) {
				window.location = "/horror/";
			} else {
				$("#error").html("ERROR Loggin in");
				$("#error").show();
			}
			return false;
		});	
	});

	$( "#register_form" ).submit(function( event ) {
	  	event.preventDefault();
		var data = {
			"c":"Login",
			"m":"register",
			"username": $( "#username" ).val(),
			"password": $( "#password" ).val(),
		};

		$.post( app_url, data)
		  .done(function( data ) {
			if (data) {
				window.location = "/horror/";
			} else {
				$("#error").html("ERROR registering username and password");
				$("#error").show();
			}
			return false;
		});
	});

	// Get Movie Container Info
	var storedData = {
		"c":"Movie",
		"m":"getStoredMovies"
	};
	$.post( app_url, storedData)
	  .done(function( data ) {
		displayMovieContainer("stored",data);
	});

	var watchedData = {
		"c":"Movie",
		"m":"getWatchedMovies"
	};
	$.post( app_url, watchedData)
	  .done(function( data ) {
		displayMovieContainer("watched",data);
	});

	var skippedData = {
		"c":"Movie",
		"m":"getSkippedMovies"
	};
	$.post( app_url, skippedData)
	  .done(function( data ) {
		displayMovieContainer("skipped",data);
	});

});

function displayMovie(obj) {
	if (!obj)
	{
		window.location = "login.php";
		return;
	}
	$("#title").html(obj.title);
    $("#poster").attr("src","https://image.tmdb.org/t/p/w640/"+obj.poster_path);
    if (obj.trailer_link) {
    	$("#trailer").html("<iframe width='420' height='315' src='https://www.youtube.com/embed/"+obj.trailer_link+"'></iframe>");
    } else {
    	$("#trailer").html("Couldn't find trailer :(");
    }
    if (obj.imdb_rating || obj.imdb_id) {
    	var imdb_html = obj.imdb_rating;
    	if (obj.imdb_id)
    	{
    		 imdb_html = "IMDB: <a href='http://www.imdb.com/title/"+obj.imdb_id+"' target='_blank'>"+obj.imdb_rating+"</a>";
    	}
    	else
    	{
    		imdb_html = "IMDB: "+obj.imdb_rating;
    	}

    	$("#imdb").html(imdb_html);
    } else {
    	$("#imdb").html("No IMDB data :(");
    }
    $("#overview").html(obj.overview);
    $("#release").html("Released: "+obj.release_date);
    $("#language").html("Language: "+obj.language);
}

function displayMovieContainer(id, objects) {

	if (!objects) return;

	var html = "";
	for (var key in objects) {
		var elem = "";
		var img = "<img width='240' src='https://image.tmdb.org/t/p/w320/"+objects[key].poster_path+"'/>";
		var title = "<span>"+objects[key].title+"</span>";
		elem = img + title;
		
		html += elem;
	}

	$("#"+id).html(html);
}