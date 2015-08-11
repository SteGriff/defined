<?php

function searchWords($word)
{
	global $wordsApi;
	return $wordsApi->searchWords(
		$word, //Term
		null, null,	//Incl, Excl partOfSpeech
		false, //Case sensitive
		3, -1, //Corpus count min-max
		1, -1, //Dictionary count min-max
		1, -1, //Length min-max
		0, 1); //Skip, take
}

function getDefinitions($word)
{
	global $wordApi;
	return $wordApi->getDefinitions($word, null, null, 10, false);
}

function getEtymologies($word)
{
	global $wordApi;
	return $wordApi->getEtymologies($word, false);
}
