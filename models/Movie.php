<?php

class Movie
{
	public static function get(PDO $db, $id)
	{
		$stmt = $db->prepare("SELECT * FROM `movies` WHERE `id` = ?");
		if (!$stmt) return false;

		$stmt->execute(array($id));
		$row = $stmt->fetch(PDO::FETCH_ASSIC);

		if ($row)
		{
			return $row;
		}

		return false;
	}

	public static function getRandom(PDO $db, $user_id, $conditions=false)
	{
		$where = " WHERE (1) ";
		$join = "";

		if (!$conditions)
		{
			$conditions = array(
				"skip_watched" => true,
				"skip_skipped" => true,
				array("imdb_rating",">","5.0"),
			);
		}

		foreach($conditions as $cond=>$value)
		{
			if (is_array($value))
			{
				$where .= " AND `".$value[0] ."` " . $value[1] . " ?";
				$whereValues[] = $value[2];
			}
			else if ($cond=="skip_watched" && $value)
			{
				$skipWatchedMovies = true;
			}
			else if ($cond == "skip_skipped" && $value)
			{
				$skipSkippedMovies = true;
			} 
		}

		// Remove results
		if ($skipWatchedMovies)
		{
			$join .= " LEFT JOIN `watched_movies` 
						ON 
							`movies`.`mdb_id`=`watched_movies`.`mdb_id`
						AND 
							`watched_movies`.`user_id`=?
			";
			$where .= " AND `watched_movies`.`id` IS NULL";
			$values[] = $user_id;
		}

		if ($skipSkippedMovies)
		{
			$join .= " LEFT JOIN `skipped_movies`
						ON 
							`movies`.`mdb_id`=`skipped_movies`.`mdb_id`
						AND 
							`skipped_movies`.`user_id`=?
			";
			$where .= " AND `skipped_movies`.`id` IS NULL";
			$values[] = $user_id;
		}

		foreach($whereValues as $vals)
		{
			$values[] = $vals;
		}

		$query = "SELECT `movies`.* FROM `movies` ".$join." ".$where." ORDER BY RAND() LIMIT 1";
		$stmt = $db->prepare($query);
		$stmt->execute($values);

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row)
		{
			self::setCurrent($db, $user_id, $row["id"]);
			return $row;
		}

		return false;
	}

	public static function getCurrent(PDO $db, $user_id)
	{
		$stmt = $db->query("SELECT * FROM `movies` WHERE `id` = (SELECT `movie_id` FROM `watching` WHERE `user_id` = ?)");
		$stmt->execute(array($user_id));

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row)
		{
			return $row;
		}
		return false;
	}

	public static function setCurrent(PDO $db, $user_id, $id)
	{
		$stmt = $db->prepare("INSERT INTO `watching` VALUES (?,?,UNIX_TIMESTAMP()) ON DUPLICATE KEY UPDATE `movie_id`=VALUES(`movie_id`),`timestamp` = UNIX_TIMESTAMP()");
		$stmt->execute(array($user_id,$id));
	}

	public static function watch(PDO $db, $user_id, $id=false)
	{
		if (!$id)
		{
			$cur = Movie::getCurrent($db, $user_id);
			$id = $cur["id"];
		}

		$stmt = $db->prepare("INSERT INTO `watched_movies` VALUES (NULL,?,?,UNIX_TIMESTAMP()) ON DUPLICATE KEY UPDATE `id`=`id`,`timestamp` = UNIX_TIMESTAMP()");
		$stmt->execute(array($id,$user_id));
	}

	public static function skip(PDO $db, $user_id, $id=false)
	{
		if (!$id)
		{
			$cur = Movie::getCurrent($db, $user_id);
			$id = $cur["id"];
		}

		$stmt = $db->prepare("INSERT INTO `skipped_movies` VALUES (NULL,?,?,UNIX_TIMESTAMP()) ON DUPLICATE KEY UPDATE `id`=`id`,`timestamp` = UNIX_TIMESTAMP()");
		$stmt->execute(array($id,$user_id));
	}

	public static function store(PDO $db, $user_id, $id=false)
	{
		if (!$id)
		{
			$cur = Movie::getCurrent($db, $user_id);
			$id = $cur["id"];
		}

		$stmt = $db->prepare("INSERT INTO `stored_movies` VALUES (NULL,?,?,UNIX_TIMESTAMP()) ON DUPLICATE KEY UPDATE `id`=`id`,`timestamp` = UNIX_TIMESTAMP()");
		$stmt->execute(array($id,$user_id));
	}

	public static function getWatchedMovies(PDO $db, $user_id)
	{
		$movies = array();

		$stmt = $db->prepare("SELECT `movies`.* FROM `watched_movies` LEFT JOIN `movies` on `movies`.`id` = `watched_movies`.`mdb_id` WHERE `user_id` = ? ORDER BY `watched_movies`.`id` ASC");
		$stmt->execute(array($user_id));

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$movies[] = $row;
		}

		return $movies;
	}

	public static function getSkippedMovies(PDO $db, $user_id)
	{
		$movies = array();

		$stmt = $db->prepare("SELECT `movies`.* FROM `skipped_movies` LEFT JOIN `movies` on `movies`.`id` = `skipped_movies`.`mdb_id` WHERE `user_id` = ? ORDER BY `skipped_movies`.`id` ASC");
		$stmt->execute(array($user_id));

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$movies[] = $row;
		}

		return $movies;
	}

	public static function getStoredMovies(PDO $db, $user_id)
	{
		$movies = array();

		$stmt = $db->prepare("SELECT `movies`.* FROM `stored_movies` LEFT JOIN `movies` on `movies`.`id` = `stored_movies`.`mdb_id` WHERE `user_id` = ? ORDER BY `stored_movies`.`id` ASC");
		$stmt->execute(array($user_id));

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$movies[] = $row;
		}

		return $movies;
	}
}