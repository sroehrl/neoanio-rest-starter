<?php

namespace Config;

use Neoan\Database\SqLiteAdapter;
use Neoan\Helper\Env;
use NeoanIo\MarketPlace\DatabaseAdapter;

class Database
{
    public function __construct()
    {
        $this->useSQLite();
    }
    private function useSQLite():void
    {
        \Neoan\Database\Database::connect(new SqLiteAdapter([
            'location' => __DIR__ . '/database.db'
        ]));
    }
    private function useMySql(): void
    {
        \Neoan\Database\Database::connect(new DatabaseAdapter([
            'host' => Env::get('DB_HOST', 'localhost'),
            'name' => Env::get('DB_NAME', 'neoan_io'),
            'port' => Env::get('DB_PORT', 3306),
            'user' => Env::get('DB_USER', 'root'),
            'password' => Env::get('DB_PASSWORD', ''),
            'charset' => Env::get('DB_CHARSET', 'utf8mb4'),
            'casing' => Env::get('DB_CASING', 'camel'),
            'assumes_uuid' => Env::get('DB_UUID', false),
            'dev_errors' => true
        ]));
    }
}