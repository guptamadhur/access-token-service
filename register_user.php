<?php
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
	$file = "\"D:\\Dropbox\\AIESEC 2015\\NST\\autoexpa\\register\"";
	$cookies = "\"D:\\Dropbox\\AIESEC 2015\\NST\\autoexpa\\cookies.txt\"";
	$fname_signin = "D:\\Dropbox\\AIESEC 2015\\NST\\autoexpa\\register";
	$fname_cookies = "D:\\Dropbox\\AIESEC 2015\\NST\\autoexpa\\cookies.txt";
}
else
{
	$wget = "wget";
	$file = "/home/admin/public_html/autoexpa/register";
	$cookies = "/home/admin/public_html/autoexpa/cookies.txt";
	$fname_signin = "/home/admin/public_html/autoexpa/register";
	$fname_cookies = "/home/admin/public_html/autoexpa/cookies.txt";
}

$command_get_auth_token = "$wget \"https://opportunities.aiesec.org/auth\" --no-check-certificate -O $file";
run_command($command_get_auth_token);

$signinpage = file_get_contents($fname_signin);
preg_match('/name=\"authenticity_token\".*value="([A-Za-z0-9+=\/]+)"/', $signinpage, $matches);
$authenticity_token = $matches[1];
// print_r($matches);

//$password = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"),0,8);

if (!isset($reg_data))
$reg_data = [
    "un" => $sheet['username'],
    "pw" => $password,
    "first" => $sheet['firstname'],
    "last" => $sheet['lastname'],
    "home_lc" => $sheet['lc']
];

$command_register_user = "$wget --post-data=\"user[email]={$reg_data['un']}&user[password]={$reg_data['pw']}&user[first_name]={$reg_data['first']}&user[last_name]={$reg_data['last']}&user[lc]={$reg_data['home_lc']}&phone={$reg_data['phone']}&user[mc]=1585&authenticity_token=$authenticity_token\" \"http://auth.aiesec.org/users\" --no-check-certificate -O $file --save-cookies $cookies";

run_command($command_register_user);
$registeredpage = file_get_contents($fname_signin);

$cookies = file_get_contents($fname_cookies);
// print_r($cookies);

@unlink($fname_signin);
@unlink($fname_cookies);
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
unset($matches);
unset($registeredpage);
