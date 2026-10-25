<?php

namespace Config;

use Neoan\Database\Adapters\MySQLAdapter;
use Neoan\Database\Adapters\SqLiteAdapter;
use Neoan\Helper\Env;

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
        \Neoan\Database\Database::connect(new MySQLAdapter([
            'host' => Env::get('DB_HOST', 'localhost'),
            'database' => Env::get('DB_NAME', 'blua_blue'),
            'port' => Env::get('DB_PORT', 3306),
            'user' => Env::get('DB_USER', 'root'),
            'password' => Env::get('DB_PASSWORD', ''),
            'dev_errors' => true
        ]));
    }
}