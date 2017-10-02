<?php

class MovieController extends Controller
{
	
	public function getNextMovie()
	{
		$data = Request::get();
		
		$user = User::get(Session::get("user_id"));

		$conds = array();
		if ($data["watched"])
		{
			Movie::watch($this->db,$user_id);
		}
		else if ($data["skip"])
		{
			Movie::skip($this->db,$user_id);
		}

		$movie = Movie::getRandom($db, $user_id);

		return $movie;
	}
}