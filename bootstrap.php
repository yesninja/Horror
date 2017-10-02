<?php

require_once("www/Request.php");

foreach (glob("models/*.php") as $filename)
{
    include $filename;
}

foreach (glob("controllers/*.php") as $filename)
{
    include $filename;
}