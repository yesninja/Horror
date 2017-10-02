var app_url = "app.php";

$( document ).ready(function() {
	
	var data = {
		"c":"Movie",
		"m":"getCurrentMovie"
	};

	$.post( app_url, data)
	  .done(function( data ) {
	    displayMovie(data);
	});

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
});

function displayMovie(obj)
{
	$("#title").html(obj.title);
    $("#poster").attr("src","https://image.tmdb.org/t/p/w640/"+obj.poster_path);
    if (obj.trailer_link) {
    	$("#trailer").html("<iframe width='420' height='315' src='https://www.youtube.com/embed/"+obj.trailer_link+"'></iframe>");
    } else {
    	$("#trailer").html("");
    }
    if (obj.imdb_rating || obj.imdb_id) {
    	var imdb_html = obj.imdb_rating;
    	if (obj.imdb_id)
    	{
    		 imdb_html = "<a href='http://www.imdb.com/title/"+obj.imdb_id+"' target='_blank'>"+obj.imdb_rating+"</a>";
    	}
    	else
    	{
    		imdb_html = "<a href='http://www.imdb.com/title/"+obj.imdb_id+"' target='_blank'>"+obj.imdb_rating+"</a>";
    	}

    	$("#imdb").html(imdb_html);
    } else {
    	$("#imdb").html("No IMDB data :(");
    }
    $("#overview").html(obj.overview);
    $("#release").html("Released: "+obj.release_date);
    $("#language").html("Language: "+obj.language);
}
