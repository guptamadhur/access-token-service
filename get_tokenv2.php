<?php
// Get the access token.
if (defined('ENV') && ENV == "dev")
	$access_token_x = file_get_contents("D:\\Dropbox\\AIESEC 2015\\NST\\autoexpa\\token.txt");
else
	$access_token_x = file_get_contents("/home/admin/public_html/autoexpa/token.txt");

// See if Access Token is legit:

$forceregen = false;
if (!isset($__EXPA_USERNAME) || !isset($__EXPA_PASSWORD))
{
	$url = "https://gis-api.aiesec.org/v2/current_person.json?access_token=$access_token_x";
	$resp = @json_decode(file_get_contents($url));
}
else
	$forceregen = true;

if ($forceregen || $resp == "" || @$resp->status->code == 401)
{
	if (defined('ENV') && ENV == "dev")
	{
		require "D:\\Dropbox\\AIESEC 2015\\NST\\autoexpa\\gen_api_keyv2.php";

		if (!isset($__EXPA_USERNAME) && !isset($__EXPA_PASSWORD))
			file_put_contents("D:\\Dropbox\\AIESEC 2015\\NST\\autoexpa\\token.txt", $API_KEY_GENERATED) or die("Error reading token file.");
	}
	else
	{
		require "/home/admin/public_html/autoexpa/gen_api_keyv2.php";
		// $access_token = API_KEY_GENERATED;
		if (!isset($__EXPA_USERNAME) && !isset($__EXPA_PASSWORD))
			file_put_contents("/home/admin/public_html/autoexpa/token.txt", $API_KEY_GENERATED) or die("Error reading token file.");
	}
}
else
{
	$API_KEY_GENERATED = $access_token_x;
}
unset($access_token_x);
unset($__EXPA_USERNAME);
unset($__EXPA_PASSWORD);