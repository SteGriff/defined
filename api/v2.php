<?php

require '../ext.php';
require '../DAL.php';
require '../views.php';

error_reporting(E_ALL);

function sendHeader($format)
{
	switch ($format)
	{
		case 'plain':
			header("content-type: text/plain");
			break;
		case 'html':
		default:
			header("content-type: text/html");
			echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"></head><body>";
			break;
	}
}

function parseContentType($acceptHeader)
{
	$acceptHeader = strtolower(trim($acceptHeader));
	$acceptHeader = str_ireplace(['text', 'application', '/'], '', $acceptHeader); 
	return $acceptHeader;
}

//Get request stuff
$word = from_request('word');
if ($word === null){
	http_fatal_400('No word specified');
}

//Spoof the accept header
// (until we support more formats)
$acceptHeader = isset($_SERVER['Accept']) ? $_SERVER['Accept'] : 'text/html';
$format = parseContentType($acceptHeader);

sendHeader($format);

//Set up client
require '../wordnik-php/wordnik/Swagger.php';
$myAPIKey = 'ac136a0a065b4ab991c0f08611306bf6e9efa80027bd69a23';
$client = new APIClient($myAPIKey, 'http://api.wordnik.com/v4');
$wordApi = new WordApi($client);
$wordsApi = new WordsApi($client);

//Prepare output string, the "view"
$view = '';

//Get the stuff

$definitions = getDefinitions($word);
$etyms = getEtymologies($word);

//Generate view
$view .= viewTitle($word, $format);
$view .= viewDefinitions($definitions, $format);
$view .= viewEtymologies($etyms, $format);

//Output
echo $view;

?>
