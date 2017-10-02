<?php

class ControllerLoader
{
	
	public static function run($class, $method)
	{
		if (!$class || !$method) return;

		$controller = $class."Controller";

		if (!class_exists($controller)) return;

		if (!method_exists($controller, $method)) return;

		$object = new $controller;

		$object->$method();

		return $object;
	}
}