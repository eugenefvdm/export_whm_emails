<?php

require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$api = new \Gufy\CpanelPhp\Cpanel([
    'host'      => getenv('HOST'),
    'username'  => getenv('USERNAME'),
    'auth_type' => getenv('AUTH_TYPE'),
    'password'  => getenv('PASSWORD')
]);

$accounts = json_decode($api->listaccts());

foreach ($accounts->acct as $account) {
    $user = $account->user;
    getEmails($user);
//    getForwards($user);
}

function getEmails($user)
{
    global $api;
    $emails = json_decode($api->listEmailAccounts($user));
    foreach ($emails->cpanelresult->data as $data) {
        echo $user . "," . $data->email . "\n";
    }
}

function getForwards($user)
{
    global $api;
    $forwards = json_decode($api->listForwards($user));
    foreach ($forwards->cpanelresult->data as $forwarder) {
        echo  $user . "," . $forwarder->dest . "->" . $forwarder->forward . "\n";
    }
}
