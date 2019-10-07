<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

include __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$inject = $dotenv->load();

require_once __DIR__ . '/App/assests/ticket.php';
