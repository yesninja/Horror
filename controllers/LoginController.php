<?php

class LoginController extends Controller
{
	
	const SALT = "PEPPERONIFACE";

	public function login()
	{
		$data = Resquest::get();

		if (!$data["username"] || !$data["password"]) return;

		$password = md5($data["password"].SALT);

		$stmt = $this->db->prepare("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?");
		$stmt->execute(array($data["username"],$password));

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if ($row)
		{
			Session::start();
			Session::set("user_id",$row["id"]);
			return true;
		}

		return false;
	}

	public function register()
	{
		$data = Resquest::get();

		if (!$data["username"] || !$data["password"]) return;

		$password = md5($data["password"].SALT);

		$stmt = $this->db->prepare("INSERT INTO `users` VALUES (NULL,?,?,UNIX_TIMESTAMP()) ON DUPLICATE KEY UPDATE `id`=`id`");
		$stmt->execute(array($data["username"],$password));

		$user_id = $this->db->lastInsertId();
		return $user_id;
	}
}