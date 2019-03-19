<?php

require __DIR__ . '/autoload.php';

if(true == isset($_GET['short_url']) && false == empty($_GET['short_url'])){
    //echo '<pre>' . print_r($_SERVER, true) . '</pre>'; die;
    $short_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/reverse.php?short_url=' . $_GET['short_url'];
}
else{
    $short_url = '';
}

include __DIR__ . '/Template/index.php';