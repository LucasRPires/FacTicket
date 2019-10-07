<?php

require '../../vendor/autoload.php';

use App\Services\Concrete\TicketService;
use Infraestructure\Repositories\Concrete\TicketRepository;
use Infraestructure\Setup\DBContext\MysqlDbFactory;

$service = new TicketService(new TicketRepository(new MysqlDbFactory()));
$service->getAllTickets();
