<?php

class Database
{
	public static function connectDB()
	{
		$host = '127.0.0.1';
		$db   = 'horror';
		$user = 'horror';
		$pass = 'kateWatchesHorrorOnOctober';
		$charset = 'utf8';

		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		$opt = [
		    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		    PDO::ATTR_EMULATE_PREPARES   => false,
		];
		
		$pdo = new PDO($dsn, $user, $pass, $opt);
		
		return $pdo;
	}
}