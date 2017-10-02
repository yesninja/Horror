<?php

class MovieController extends Controller
{
	
	public function getNextMovie()
	{
		$data = Request::get();
		$db = Database::connectDB();

		$conds = array();
		if ($data["watched"])
		{
			Movie::watch($db,"1");
		}
		else if ($data["skip"])
		{
			Movie::skip($db,"1");
		}

		$movie = Movie::getRandom($db, "1");

		return $movie;
	}
}