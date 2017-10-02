<?php

class Controller
{
	private $_response = array();

	public function getResponse()
	{
		return json_encode($_response);
	}
}