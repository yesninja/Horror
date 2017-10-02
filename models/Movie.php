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
		$where = "WHERE ";
		$join = "";

		if (!$conditions)
		{
			$conditions = array(
				"skip_watched" = true,
				"skip_skipped" = true,
				array("imdb_rating",">","5.0"),
			);
		}

		foreach($conditions as $cond)
		{
			if ($cond=="skip_watched")
			{
				$skipWatchedMovies = true;
			}
			else if ($cond == "skip_skipped")
			{
				$skipSkippedMovies = tru;
			}
			else if (is_array($cond))
			{
				$where .= " `".$cond[0] ."` " . $cond[1] . " ?";
				$values[] = $cond[2];
			} 
		}

		$values[] = $user_id;

		// Remove results
		if ($skipWatchedMovies)
		{
			$join = " LEFT JOIN `watched_movies` 
						ON 
							`movies`.`mdb_id`=`watched_movies`.`mdb_id`
						AND 
							`watched_movies`.`user_id`=?
			";
			$where .= " `watched_movies`.`id` IS NULL";
		}

		if ($skipSkippedMovies)
		{
			$join = " LEFT JOIN `skipped_movies` 
						ON 
							`movies`.`mdb_id`=`skipped_movies`.`mdb_id`
						AND 
							`skipped_movies`.`user_id`=?
			";
			$where .= " `skipped_movies`.`id` IS NULL";
		}

		$query = "SELECT * FROM `movies` ".$join." ".$where." LIMIT 1";
		$stmt = $db->prepare($query);
		$stmt->execute($values);

		echo $query;
	}
}