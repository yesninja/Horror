<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

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

Session::start();
Request::load($_GET,$_POST);

$controller = ControllerLoader::run($controller,$method);

if ($controller)
{
	header('Content-Type: application/json');
	echo $controller->getResponse();
}
else
{
	echo "No Response from $controller :: $method ()";
}