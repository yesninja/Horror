<?php

class MovieController extends Controller
{
	
	public function getCurrentMovie()
	{
		$data = Request::get();
		
		$user = User::get($this->db,Session::get("user_id"));
		if (!$user) return false;

		$movie = Movie::getCurrentMovie();

		if (!$movie)
		{
			$movie = Movie::getRandom($this->db, $user->id);
		}

		return $movie;
	}

	public function getNextMovie()
	{
		$data = Request::get();
		
		$user = User::get($this->db,Session::get("user_id"));
		if (!$user) return false;
		
		$user_id = $user->id;

		$conds = array();
		if ($data["watched"])
		{
			Movie::watch($this->db,$user_id);
		}
		else if ($data["skip"])
		{
			Movie::skip($this->db,$user_id);
		}

		$movie = Movie::getRandom($this->db, $user_id);

		return $movie;
	}
}