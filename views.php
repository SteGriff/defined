<?php

function dictionaryAttribution($dictionaryCode, $type)
{
	$friendlyName = dictionaryFriendlyName($dictionaryCode);
	
	switch ($type)
	{
		case 'plain':
			return $friendlyName;
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
		default:
			return '';
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
		case 'plain':
			foreach ($defs as $d)
			{
				$response .= "{$d->partOfSpeech}: {$d->text}\r\n";
			}
			break;
		case 'html':
			foreach ($defs as $d)
			{			
				if ($lastSource === '')
				{
					//First dictionary
					$lastSource = $d->sourceDictionary;
					$response .= dictionaryAttribution($lastSource, $type) . " <dl>";
				}
				elseif ($lastSource != $d->sourceDictionary)
				{
					//New dictionary
					$lastSource = $d->sourceDictionary;
					$response .= "</dl> " . dictionaryAttribution($lastSource, $type) . " <dl>";
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

function viewTitle($title, $type)
{
	$response = '';
	
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
		case 'plain':
		default:
			$response = "$title\r\n";
			break;
	}
	return $response;
}
