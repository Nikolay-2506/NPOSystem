<?php

use App\Short_url;

require __DIR__ . '/autoload.php';

$short = new Short_url;

$short->long_url = $_POST['url'];

$short = $short->urlToShortCode();

header('Location: index.php?short_url=' . $short->short_url);


/*echo '<pre>';
var_dump($_POST);
//print_r($array);
echo '</pre>';*/