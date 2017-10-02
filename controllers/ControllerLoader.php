<?php

class ControllerLoader
{
	
	public static function run($class, $method)
	{
		if (!$class || !$method) return false;

		$controller = $class."Controller";

		if (!class_exists($controller)) return false;

		if (!method_exists($controller, $method)) return false;

		$object = new $controller;

		if (!$object->no_auth)
		{
			if (!Session::isLoggedIn())
			{
				exit(255);
			}
		}

		$object->$method();

		return $object;
	}
}