<?php

class Session
{
	
	public static function isLoggedIn()
	{
		if (self::get("user_id"))
		{
			return true;
		}

		return false;
	}

	public static function start()
	{
		session_start();
	}

	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public static function get($key)
	{
		return $_SESSION[$key];
	}
}