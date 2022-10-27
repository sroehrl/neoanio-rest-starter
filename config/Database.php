<?php

namespace Config;

use Neoan\Database\SqLiteAdapter;

class Database
{
    public function __construct()
    {
        \Neoan\Database\Database::connect(new SqLiteAdapter([
            'location' => __DIR__ . '/database.db'
        ]));
    }
}