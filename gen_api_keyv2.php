<?php
require "vendor/autoload.php";
require "apicredentials.php";

$obj = new \GISwrapper\AuthProviderEXPA($un, $pw);
$API_KEY_GENERATED = $obj->getToken();

/*
$file = basename(__FILE__);
if(@eregi($file,$_SERVER['REQUEST_URI']))
    ;
	// die('This file cannot be accessed directly!');

function run_command($bin, $command = '', $force = true)
{
    $stream = null;
    $bin .= $force ? ' 2>&1' : '';

    $descriptorSpec = array
    (
        0 => array('pipe', 'r'),
        1 => array('pipe', 'w')
    );

    $process = proc_open($bin, $descriptorSpec, $pipes);

    if (is_resource($process))
    {
        fwrite($pipes[0], $command);
        fclose($pipes[0]);

        $stream = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        proc_close($process);
    }

    return $stream;
}
error_reporting(E_ALL);
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
{
	$wget = "D:\\Dropbox\\\"AIESEC 2015\"\\NST\\autoexpa\\wget.exe";
	$file = "\"D:\\Dropbox\\AIESEC 2015\\NST\\autoexpa\\sign_in\"";
	$cookies = "\"D:\\Dropbox\\AIESEC 2015\\NST\\autoexpa\\cookies.txt\"";
	$fname_signin = "D:\\Dropbox\\AIESEC 2015\\NST\\autoexpa\\sign_in";
	$fname_cookies = "D:\\Dropbox\\AIESEC 2015\\NST\\autoexpa\\cookies.txt";
}
else
{
	$wget = "wget";
	$file = "/home/admin/public_html/autoexpa/sign_in";
	$cookies = "/home/admin/public_html/autoexpa/cookies.txt";
	$fname_signin = "/home/admin/public_html/autoexpa/sign_in";
	$fname_cookies = "/home/admin/public_html/autoexpa/cookies.txt";
}

// The things you have to do to make legacy code work :P
if (!(isset($__EXPA_USERNAME) && isset($__EXPA_PASSWORD)))
    require "apicredentials.php";
else
{
    $un = $__EXPA_USERNAME;
    $pw = $__EXPA_PASSWORD;
}

$command_get_auth_token = "$wget \"http://experience.aiesec.org\" --no-check-certificate -O $file";
run_command($command_get_auth_token);

$signinpage = file_get_contents($fname_signin);
preg_match('/name=\"authenticity_token\".*value="([A-Za-z0-9+=\/]+)"/', $signinpage, $matches);
print_r($matches);

if (!isset($matches[1]))
    die("Authenticity token was not found. The Sign In page is most likely not working. #CatastrophicFailure"); // TODO: make this more informative

$authenticity_token = $matches[1];

$command_get_cookie = "$wget --save-cookies $cookies --keep-session-cookies --post-data=\"commit=Sign%20in&user[email]=$un&user[password]=$pw&authenticity_token=$authenticity_token\" \"http://auth.aiesec.org/users/sign_in\" --no-check-certificate -O $file";

echo $command_get_cookie;

run_command($command_get_cookie);
$cookies = file_get_contents($fname_cookies);
preg_match("/expa_token\t(.*)/", $cookies, $matches);
print_r($matches);
$API_KEY_GENERATED = @trim(preg_replace('/\s+/', ' ', $matches[1]));

// @unlink($fname_signin);
// @unlink($fname_cookies);
unset($wget);
unset($file);
unset($cookies);
unset($un);
unset($pw);
unset($fname_signin);
unset($fname_cookies);
unset($signinpage);
unset($command_get_cookie);
unset($command_get_auth_token);
unset($matches);*/