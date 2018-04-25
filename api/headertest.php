<?php

function parseContentType($acceptHeader)
{
	echo "Accept: $acceptHeader\r\n";
	$acceptHeader = strtolower(trim($acceptHeader));
	$acceptHeader = str_ireplace(['text', 'application', '/'], '', $acceptHeader); 
	echo "Accept: $acceptHeader\r\n";
	return $acceptHeader;
}

echo "Start";

//Get the accept header
$acceptHeader = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : 'text/html';
$format = parseContentType($acceptHeader);
echo "Format: $format\r\n";

var_dump($_SERVER);
