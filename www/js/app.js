var app_url = "app.php";
var currentMovieData = "";

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
		  	addSmallMovieToContainer("watched",currentMovieData);
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
		  addSmallMovieToContainer("skipped",currentMovieData);
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
		  addSmallMovieToContainer("stored",currentMovieData);
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
	if (!obj) {
		window.location = "login.php";
		return;
	}
	currentMovieData = obj;

	// Go get movie links...
	var movieLinkData = {
		"c":"Movie",
		"m":"getMovieLinks",
		"title":obj.title
	};

	$.post( app_url, movieLinkData)
	  .done(function( data ) {
		displayMovieLinks(data);
	});

	$("#title").html(obj.title);
	if (obj.poster_path) {
  	$("#poster").attr("src","https://image.tmdb.org/t/p/w640/"+obj.poster_path);
  } else {
  	$("#poster").attr("src","www/images/no-image-640.png");
  }
  if (obj.trailer_link) {
  	$("#trailer").html("<iframe width='420' height='315' src='https://www.youtube.com/embed/"+obj.trailer_link+"'></iframe>");
  } else {
  	$("#trailer").html("Couldn't find trailer :(");
  }
  if (obj.imdb_rating || obj.imdb_id) {
  	var imdb_html = obj.imdb_rating;
  	if (obj.imdb_id) {
  		 imdb_html = "IMDB: <a href='http://www.imdb.com/title/"+obj.imdb_id+"' target='_blank'>"+obj.imdb_rating+"</a>";
  	}	else {
  		imdb_html = "IMDB: "+obj.imdb_rating;
  	}

  	$("#imdb").html(imdb_html);
  } else {
  	$("#imdb").html("No IMDB data :(");
  }

  $("#overview").html(obj.overview);
  $("#release").html(obj.status+": "+obj.release_date);
  if (obj.runtime) {
  	$("#runtime").html("Runtime: "+obj.runtime+"m");
  } else {
  	$("#runtime").html("Runtime: N/A");
  }

  $("#language").html("Language: "+obj.language);

  if (obj.conditions) {
  	var search_html = "<div>Search Query: ";
  	for (var key in obj.conditions) {
  		if (typeof obj.conditions[key] === 'object') {
  			search_html += "<span>"+obj.conditions[key][0]+" "+obj.conditions[key][1]+" "+obj.conditions[key][2]+"<span>";
  		}
  	}
  	search_html += "</div>";
  	$("#search_conditions").html(search_html);
  }

  if (obj.counts) {
  	var count_html = "<div id='counts'>";
  	count_html += "<div>Total Movies: "+obj.counts.query+" / "+obj.counts.total+"  </div>";
  	count_html += "<div>Total Watched: "+obj.counts.watched+"</div>";
  	count_html += "<div>Total Stored: "+obj.counts.stored+"</div>";
  	count_html += "<div>Total Skipped: "+obj.counts.skipped+"</div>";
  	count_html += "</div>";
  	$("#watch_counts").html(count_html);
  }
    
}

function displayMovieContainer(id, objects) {

	if (!objects) return;

	var html = "";
	for (var key in objects) {
		if (!objects[key].id) continue;

		 var elem = getSmallMovieHTML(objects[key]);
		 html += elem;
	}

	$("#"+id+" span.holder").append(html);
	addToolTip(id);
}

function displayMovieLinks(objects) {

	var html = "";
	var sources = [];
	console.log(objects);
	if (objects && typeof objects === "object")
	{
		for (var key in objects) {
			var object = objects[key];
			var elem = "";
			var link = "#";
			var price = "";
			if (sources.indexOf(object.source) > -1)
			{
				continue;
			}
			
			// only one of each source for now
			sources.push(object.source);
			if (object.link) {
				link = object.link;
			}

			if (object.price) {
				// disabled for now as it isn't accurate
				//price = object.price;
			}

			elem = "<div class='movie-link'><a target='_blank' href='"+link+"'><img src='http://cdn.flixfindr.com/static/img/sources-"+object.source+"-white.svg'/><span>"+price+"</span></a></div>";
			html += elem;
		}
	}
	else
	{
		html = "No Movie Links Found";
	}

	$("#movie_links span.movie-links-container").html(html);
}

function addSmallMovieToContainer(id,obj) {
	if (!obj.id) return;

	var elem = getSmallMovieHTML(obj);
	$("#"+id+" span.holder").prepend(elem);
	addToolTip("small-movie-"+obj.id);
}


function getSmallMovieHTML(obj) {
	var elem = "<div id='small-movie-"+obj.id+"' class='small-movie' data-movie-id='"+obj.id+"'>";
	if (obj.poster_path) {
		elem += "<img class='small-movie-poster' src='https://image.tmdb.org/t/p/w320/"+obj.poster_path+"'/>";
  } else {
  	elem += "<img class='small-movie-poster' src='www/images/no-image-300.png'/>";
  }
	elem += "<span style='display:none;' class='small-movie-title'>"+obj.title+"</span>";
	elem += "</div>";

	return elem;
}


function addToolTip(id) {
			$( "#"+id ).tooltip({
		  items: "[data-movie-id]",
		  content: function() {
	      	var element = $( this );
		  		var movie_id = element.data("movie-id");
	      	var title = "<span class='tooltip-title'>"+element.children( "span.small-movie-title" )[0].innerText + "</span>";
	      	var button = "<button data-movie-id='"+movie_id+"' class='button tooltip-button'>Make Current</button>";
	      	return title + button;
	      },
	      hide: {
	        effect: "bounce",
	        delay: 250
	      },
				open: function(event, ui)
		    {
	        if (typeof(event.originalEvent) === 'undefined')
	        {
	            return false;
	        }
	        
	        var $id = $(ui.tooltip).attr('id');
	        
	        // close any lingering tooltips
	        $('div.ui-tooltip').not('#' + $id).remove();
	        
	        // ajax function to pull in data and add it to the tooltip goes here
		    },
		    close: function(event, ui)
		    {
	        ui.tooltip.hover(function()
	        {
	            $(this).stop(true).fadeTo(400, 1); 
	        },
	        function()
	        {
	            $(this).fadeOut('400', function()
	            {
	                $(this).remove();
	            });
	        });
			  }
	  });
}