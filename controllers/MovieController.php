<?php

class MovieController extends Controller
{
	
	public function getCurrentMovie()
	{
		$data = Request::get();
		
		$user = User::get($this->db,Session::get("user_id"));
		if (!$user) return false;

		$movie = Movie::getCurrent($this->db, $user->id);

		if (!$movie)
		{
			$movie = Movie::getRandom($this->db, $user->id);
		}

		$this->response = $movie;
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
		else if ($data["store"])
		{
			Movie::store($this->db,$user_id);
		}

		$movie = Movie::getRandom($this->db, $user_id);

		$this->response = $movie;
	}

	public function getWatchedMovies()
	{
		$data = Request::get();
		
		$user = User::get($this->db,Session::get("user_id"));
		if (!$user) return false;

		$movies = Movie::getWatchedMovies($this->db, $user->id);

		$this->response = $movies;
	}

	public function getSkippedMovies()
	{
		$data = Request::get();
		
		$user = User::get($this->db,Session::get("user_id"));
		if (!$user) return false;

		$movies = Movie::getSkippedMovies($this->db, $user->id);

		$this->response = $movies;
	}

	public function getStoredMovies()
	{
		$data = Request::get();
		
		$user = User::get($this->db,Session::get("user_id"));
		if (!$user) return false;

		$movies = Movie::getStoredMovies($this->db, $user->id);

		$this->response = $movies;
	}

	public function makeCurrent()
	{
		$data = Request::get();
		
		$user = User::get($this->db, Session::get("user_id"));
		if (!$user) return false;

		if (!$data["id"]) return false;

		$id = $data["id"];

		// When making a movie current skip the current one
		Movie::skip($this->db,$user->id);
		Movie::setCurrent($this->db,$user->id,$id);
		$movie = Movie::get($this->db,$user->id,$id);

		$this->response = $movie;
	}

	public function getMovieLinks()
	{
		$data = Request::get();
		
		$user = User::get($this->db, Session::get("user_id"));
		if (!$user) return false;

		if (!$data["title"]) return false;

		$title = $data["title"];

		$movie_links = Movie::getMovieLinks($title);

		$this->response = $movie_links;
	}
}