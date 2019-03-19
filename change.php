<?php

use App\Short_url;

include __DIR__ . '/autoload.php';

$record = new Short_url;

$record->id = (int) $_POST['rec'];
$record = $record::findById($record->id);
$record->delete();
$record->urlToShortCode();

header('Location: ' . $_SERVER['REQUEST_SCHEME']. '://' . $_SERVER['HTTP_HOST'] . '/table.php');

