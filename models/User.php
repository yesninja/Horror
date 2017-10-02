<?php

class User
{
	private $_id;
	private $_data;
	private $_username;


	public function __construct($id, $data)
	{
		$this->_id = $id;
		$this->_data = $data;
	}

	public static function create(PDO $db, array $data)
	{

	}

	public static function get(PDO $db,$id)
	{
		$stmt = $db->prepare("SELECT * FROM `users` WHERE `id` = ?");
		$stmt->execute(array($id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row)
		{
			$user_id = $row["id"];
			unset($row["id"]);
			$user = new User($user_id,$row);
			return $user;
		}

		return false;
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