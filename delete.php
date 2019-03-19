<?php

use App\Short_url;

include __DIR__ . '/autoload.php';

$record = new Short_url;

$record->id = (int) $_POST['rec'];

$record->delete();

header('Location: ' . $_SERVER['REQUEST_SCHEME']. '://' . $_SERVER['HTTP_HOST'] . '/table.php');

