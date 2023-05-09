<?php

use Eugenevdm\WhmApi\Cpanel;

require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//echo print_r($_ENV['HOST'], true);
//die();

$api = new Cpanel([
    'host'      => $_ENV['WHM_HOST'],
    'username'  => $_ENV['WHM_USERNAME'],
    'auth_type' => $_ENV['WHM_AUTH_TYPE'],
    'password'  => $_ENV['WHM_PASSWORD']
]);

//echo print_r($api->listAccounts(), true);
//die();

//$accounts = json_decode($api->listAccounts());
//die();

$accounts = $api->listAccounts();

foreach ($accounts['acct'] as $account) {
    $user = $account['user'];
    getEmails($user);
}

function getEmails($user)
{
    global $api;

    $emails = $api->listEmailAccounts($user);
    
    foreach ($emails['cpanelresult']['data'] as $data) {
        echo $user . "," . $data['email'] . "\n";
    }
}

