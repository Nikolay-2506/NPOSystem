<?php

use App\Short_url;

include __DIR__ . '/autoload.php';

$long = new Short_url;

$long->short_url = $_GET['short_url'];

$long = $long->shortCodeToUrl();

header('Location: ' . $long->long_url);

