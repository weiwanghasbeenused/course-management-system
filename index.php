<?php

$request = $_SERVER['REQUEST_URI'];
$requestclean = strtok($request,"?");
$uri = explode('/', $requestclean);


require_once("views/head.php");
require_once("views/nav.php");

if(!$uri[1])
	require_once("views/home.php");
elseif( $uri[1] == 'list')
	require_once("views/list.php");
elseif($uri[1] == 'add') 
	require_once("views/add.php");
elseif($uri[1] == 'edit') 
	require_once("views/edit.php");
elseif($uri[1] == 'delete') 
	require_once("views/delete.php");
elseif($uri[1] == 'search') 
	require_once("views/search.php");

require_once("views/foot.php");

?>