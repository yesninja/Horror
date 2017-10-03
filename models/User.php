<?php

class User
{
	public $id;
	private $_data;
	private $_username;


	public function __construct($id, $data)
	{
		$this->id = $id;
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
}