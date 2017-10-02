<?php

class ControllerLoader
{
	
	public static function run($class, $method)
	{
		if (!$class || !$method) return;

		$controller = $class."Controller";
		
		if (!file_exists($controller)) return;

		require_once($controller);

		if (!class_exists($controller)) return;

		if (!method_exists($class, $method)) return;

		$object = new $controller;

		$object->$method;

		return $object;
	}
}