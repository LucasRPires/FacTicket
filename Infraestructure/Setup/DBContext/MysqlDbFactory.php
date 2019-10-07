<?php

namespace Infraestructure\Setup\DBContext;

use Exception;
use Infraestructure\Setup\Contract\IDBContext;

class MysqlDbFactory implements IDBContext
{
    private $host;
    private $database;
    private $port;
    private $user;
    private $pass;
    private static $dotenv;

    function __construct()
    {
        self::$dotenv = \Dotenv\Dotenv::create(dirname(__DIR__) . '../../../');
        self::$dotenv->overload();

        $this->host = $_ENV['MYSQL_HOST'];
        $this->database = $_ENV['MYSQL_DB'];
        $this->port = $_ENV['MYSQL_PORT'];
        $this->user = $_ENV['MYSQL_USER'];
        $this->pass = $_ENV['MYSQL_PASS'];
    }

    public function connect()
    {
        try {
            $mysql = new \mysqli($this->host, $this->user, $this->pass, $this->database, $this->port);
            if ($mysql->connect_error)
                throw new Exception();
            return $mysql;
        } catch (Exception $e) {
            throw new \Exception("Algo de errado ocorreu.");
        }
    }
}
