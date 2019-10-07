<?php
require '../../vendor/autoload.php';

use App\Services\Concrete\ClientService;
use Infraestructure\Repositories\Concrete\ClientRepository;
use Infraestructure\Setup\DBContext\MysqlDbFactory;

$service = new ClientService(new ClientRepository(new MysqlDbFactory));
$service->getAllClients();
