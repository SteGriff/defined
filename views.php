<?php

function dictionaryAttribution($dictionaryCode, $type)
{
	$friendlyName = dictionaryFriendlyName($dictionaryCode);
	
	switch ($type)
	{
		case 'html':
		default:
			return "<h3>$friendlyName</h3>";
			break;
	}
}	

function dictionaryFriendlyName($dictionaryCode)
{
	switch ($dictionaryCode)
	{
		case 'ahd-legacy':
			return "American Heritage Dictionary";
		case 'wiktionary':
			return "Wiktionary";
	}
}

function viewDefinitions($defs, $type)
{
	$lastSource = '';
	$response = '';
	
	if ($defs == null)
	{
		return $response;
	}
	
	switch ($type)
	{
		case 'html':
			$response = '';
			foreach ($defs as $d)
			{			
				if ($lastSource === '')
				{
					//First dictionary
					$lastSource = $d->sourceDictionary;
					$response .= dictionaryAttribution($lastSource, 'html') . " <dl>";
				}
				elseif ($lastSource != $d->sourceDictionary)
				{
					//New dictionary
					$lastSource = $d->sourceDictionary;
					$response .= "</dl> " . dictionaryAttribution($lastSource, 'html') . " <dl>";
				}
				//Else: same dictionary (do nothing)
				
				$response .= "\n<dt>{$d->word} <b>({$d->partOfSpeech})</b></dt>";
				$response .= "<dd>{$d->text}</dd>";
			}
			$response .= '</dl>';
			break;
	}
	return $response;
}


function viewEtymologies($etyms, $type)
{	
	$response = '';
	
	if ($etyms == null)
	{
		return $response;
	}
	
	switch ($type)
	{
		case 'html':
			$response = '<ul>';			
			foreach ($etyms as $e)
			{
				$e = str_replace("<?xml version=\"1.0\" encoding=\"UTF-8\"?>", '', $e);
				$response .= "<li>$e</li>";
			}
			$response .= '</ul>';
			break;
	}
	return $response;
}
