<?php

require '../ext.php';
require '../DAL.php';
require '../views.php';
require '../wordnik-php/wordnik/Swagger.php';

error_reporting(E_ALL);

function sendHeader($format)
{
	switch ($format)
	{
		case 'html':
		default:

			echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"></head><body>";
			// break;
	}
}

//Get request stuff
$word = from_request('word');
if ($word === null){
	http_fatal_400('No word specified');
}

//Spoof the accept header
// (until we support more formats)
$format = 'html';

sendHeader($format);

//Set up client
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
$view .= "<h2>$word</h2>";
$view .= viewDefinitions($definitions, $format);
$view .= viewEtymologies($etyms, $format);

//Output
echo $view;

?>
