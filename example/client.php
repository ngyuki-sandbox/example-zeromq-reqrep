<?php
namespace Example;

require_once __DIR__ . '/../vendor/autoload.php';

function log($str)
{
    fprintf(STDERR, "[%05d] %s\n", getmypid(), $str);
}

$client = new RpcClient();
$data = implode(' ', array_slice($_SERVER['argv'], 1));

$res = $client->call($data);
log(var_export($res, true));

$res = $client->call($data);
log(var_export($res, true));

$res = $client->call($data);
log(var_export($res, true));

$res = $client->call($data);
log(var_export($res, true));

$res = $client->call($data);
log(var_export($res, true));

$res = $client->call($data);
log(var_export($res, true));

$res = $client->call($data);
log(var_export($res, true));

$res = $client->call($data);
log(var_export($res, true));
