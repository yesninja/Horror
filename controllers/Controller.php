<?php

class Controller
{
	public $response = array();
	public $db;
	public $no_auth = false;

	public function __construct()
	{
		$this->db = Database::connectDB();
	}

	public function getResponse()
	{
		return json_encode($this->response);
	}
}