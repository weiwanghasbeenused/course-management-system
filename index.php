<?php

$request = $_SERVER['REQUEST_URI'];
$requestclean = strtok($request,"?");
$uri = explode('/', $requestclean);


require_once("views/head.php");
require_once("views/nav.php");

if(!$uri[1] || $uri[1] == 'list')
	require_once("views/list.php");
elseif($uri[1] == 'add') 
	require_once("views/add.php");

require_once("views/foot.php");

?>