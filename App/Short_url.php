<?php

namespace App;


class Short_url extends Model
{
    public static $table = 'short_url';

    public $id;
    public $long_url;
    public $short_url;
    public $date;
}