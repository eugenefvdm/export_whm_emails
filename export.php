<?php

use Eugenevdm\WhmApi\Cpanel;

require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Check if the required command line parameter is provided
if ($argc != 2) {
    echo "Usage:\n";
    echo " php export.php username\n";
    echo " php export.php all\n";
    exit(1);
}

$username = $argv[1];

$api = new Cpanel([
    'host'      => $_ENV['WHM_HOST'],
    'username'  => $_ENV['WHM_USERNAME'],
    'auth_type' => $_ENV['WHM_AUTH_TYPE'],
    'password'  => $_ENV['WHM_PASSWORD']
]);

if ($argv[1] == "all") {
    getAccounts($api);
} else {
    getEmailUsage($api, $username);
}

// Retrieve all email accounts and their usage for a given cPanel user and write to a CSV file
function getEmailUsage($api, $username) {
    $data = $api->execute_action(
        '3',
        'Email',
        'list_pops_with_disk',
        $username
    );

    $stream = fopen($username . ".csv", 'a');

    foreach($data['result']['data'] as $emailAccount) {
        $line = $emailAccount['login']
            . ","
            . $emailAccount['diskused']
            . ","
            . $emailAccount['diskquota'] . "\n";
        echo $line;
        fwrite($stream, $line);
    }
    fclose($stream);
}

// Retrieve all accounts with mailbox names and write it to a CSV file called `all.csv`
function getAccounts($api) {
    $accounts = $api->listAccounts();

    $stream = fopen("all.csv", 'a');

    foreach ($accounts['acct'] as $account) {
        $user = $account['user'];
        $emails = $api->listEmailAccounts($user);
        foreach ($emails['cpanelresult']['data'] as $data) {
            $line = $user . "," . $data['email'] . "\n";
            echo $line;
            fwrite($stream, $line);
        }
    }
    fclose($stream);
}


