<?php

// Include ThosHost API class.
require('thoshost_API_class.inc.php');


//  Initiate the base for API calls
$API = new TH_API('API_KEY', 'API_PASSWORD');

// Get account information
$accData = $API->getAccount();

// Catch errors and retreive the correct answer and status;
$accDetails = json_decode($accData, true);

if(isset($accDetails['status']) && $accDetails['status'] == 'OK')
{
	// Print account details preserving whitespaces
	$API->p($accDetails['answer']);
}
else if(isset($accDetails['status']) && $accDetails['status'] == 'cUrlError')
{
	// If a cURL error is found, display it
	echo 'cURL Error: '.$accDetails['answer'];
}
else if(isset($accDetails['status']) && $accDetails['status'] == 'FALSE')
{
	// If an API problem is found, display the message
	echo 'Error: '.$accDetails['answer'];
}
else
{
	// If there is an invalid answer, display it
	$API->p($accDetails['answer']);
}

?>
