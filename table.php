<?php

use App\Short_url;

include __DIR__ . '/autoload.php';

$records = Short_url::findAll();

include __DIR__ . '/Template/table.php';

//echo '<pre>' . print_r($records, true) . '</pre>';