<?php

class LoginController extends Controller
{
	
	const SALT = "PEPPERONIFACE";
	public $no_auth = true;

	public function login()
	{
		$data = Request::get();

		if (!$data["username"] || !$data["password"]) return;

		$password = md5($data["password"].self::SALT);

		$stmt = $this->db->prepare("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?");
		$stmt->execute(array($data["username"],$password));

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if ($row)
		{
			Session::set("user_id",$row["id"]);
			return true;
		}

		return false;
	}

	public function register()
	{
		$data = Request::get();

		if (!$data["username"] || !$data["password"]) return;

		$password = md5($data["password"].self::SALT);

		$stmt = $this->db->prepare("INSERT INTO `users` VALUES (NULL,?,?,UNIX_TIMESTAMP()) ON DUPLICATE KEY UPDATE `id`=`id`");
		$stmt->execute(array($data["username"],$password));

		$user_id = $this->db->lastInsertId();
		return $user_id;
	}
}