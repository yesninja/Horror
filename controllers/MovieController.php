<?php

class MovieController extends Controller
{
	
	public function getNextMovie()
	{
		$data = Request::get();
		$db = new Database();

		$movie = Movie::getRandom($db, "1");
		print_r($movie);
		return $movie;
	}
}