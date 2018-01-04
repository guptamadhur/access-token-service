<?php
$access_token = $_GET['access_token'];
// See if Access Token is legit:
$url = "https://gis-api.aiesec.org/v1/current_person.json?access_token=$access_token";
$resp = @json_decode(file_get_contents($url));

if ($resp == "" or @$resp->status->code == 401)
	$access_token_valid = false;
else
	$access_token_valid = true;

unset($access_token);