<?php

class Controller
{
	public $response = array();

	public function getResponse()
	{
		return json_encode($this->response);
	}
}