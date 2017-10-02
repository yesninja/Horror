<?php

class User
{
	private $id;

	public function create(array $data)
	{

	}

	public function get(PDO $db,$id)
	{

	}

	public function nextMovie(PDO $db,$user_id,$conditions=false)
	{
		$movie = false;

		if ($this->id)
		{
			$movie = Movie::RandMovie($db,$this->id,$conditions);
		}

		return $movie;
	}

	public function watchedMovies()
	{


	}

	public function skippedMovies()
	{

	}
}

/*

CREATE TABLE users(
	id bigint(20) AUTO_INCREMENT,
	username varchar(255),
	password varchar(255),
	KEY(id)
);

CREATE TABLE watched_movies(
	id bigint(20) AUTO_INCREMENT,
	mdb_id bigint(20),
	user_id bigint(20),
	KEY(id),
	KEY(mdb_id),
	UNIQUE(mdb_id,user_id)
);

CREATE TABLE skipped_movies(
	id bigint(20) AUTO_INCREMENT,
	mdb_id bigint(20),
	user_id bigint(20),
	KEY(id),
	KEY(mdb_id),
	UNIQUE(mdb_id,user_id)
);

*/