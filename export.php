<?php

use Eugenevdm\WhmApi\Cpanel;

require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Check if the required command line parameter is provided
if ($argc != 2) {
    echo "Usage: php export.php [filename]\n";
    exit(1);
}

// Retrieve the command line parameter
$filename = $argv[1];

$api = new Cpanel([
    'host'      => $_ENV['WHM_HOST'],
    'username'  => $_ENV['WHM_USERNAME'],
    'auth_type' => $_ENV['WHM_AUTH_TYPE'],
    'password'  => $_ENV['WHM_PASSWORD']
]);

$accounts = $api->listAccounts();

foreach ($accounts['acct'] as $account) {
    $user = $account['user'];

    $emails = $api->listEmailAccounts($user);

    $stream = fopen($filename, 'a');

    foreach ($emails['cpanelresult']['data'] as $data) {
        echo $user . "," . $data['email'] . "\n";
        fwrite($stream, $user . "," . $data['email'] . "\n");
    }

    fclose($stream);
}
