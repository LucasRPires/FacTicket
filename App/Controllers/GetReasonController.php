<?php

require '../../vendor/autoload.php';

use App\Services\Concrete\ReasonService;
use Infraestructure\Repositories\Concrete\ReasonRepository;
use Infraestructure\Setup\DBContext\MysqlDbFactory;


$service = new ReasonService(new ReasonRepository(new MysqlDbFactory()));
$service->getAllReasons();
