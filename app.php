<?php

require_once("bootstrap.php");

$controller = $_POST["c"];
$method = $_POST["m"];

if (!$controller)
{
	$controller = $_GET["c"];
}

if (!$method)
{
	$method = $_GET["m"];
}

unset($_POST["c"]);
unset($_POST["m"]);
unset($_GET["c"]);
unset($_GET["m"]);

Request::load($_GET,$_POST);

$controller = ControllerLoader::run($c,$m);

echo $controller->getResponse();