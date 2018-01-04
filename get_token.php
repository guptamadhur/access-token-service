<?php
// Get the access token.
$access_token_x = file_get_contents("/home/admin/public_html/autoexpa/token.txt");

// See if Access Token is legit:
$url = "https://gis-api.aiesec.org/v2/current_person.json?access_token=$access_token_x";
$resp = @json_decode(file_get_contents($url));

if ($resp == "" || @$resp->status->code == 401)
{
	require "/home/admin/public_html/autoexpa/gen_api_key.php";
	// $access_token = API_KEY_GENERATED;
	file_put_contents("/home/admin/public_html/autoexpa/token.txt", API_KEY_GENERATED) or die("Error reading token file.");
}
else
{
	define("API_KEY_GENERATED", $access_token_x);
}
unset($access_token_x);