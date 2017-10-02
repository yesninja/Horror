<?php

class Request
{
	
	private static $_get = array();
	private static $_post = array();

	public static function load($get, $post)
	{
		self::$_get = $get;
		self::$_post = $post;
	}

	public static function get()
	{
		return array_merge(self::$_post,self::$_get);
	}
}