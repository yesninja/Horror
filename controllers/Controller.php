<?php

class Controller
{
	public $response = array();
	public $db;

	public function __construct()
	{
		$this->db = Database::connectDB();
	}

	public function getResponse()
	{
		return json_encode($this->response);
	}
}