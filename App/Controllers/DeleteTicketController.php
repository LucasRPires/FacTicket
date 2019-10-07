<?php

require '../../vendor/autoload.php';

use App\Services\Concrete\TicketService;
use Infraestructure\Repositories\Concrete\TicketRepository;
use Infraestructure\Setup\DBContext\MysqlDbFactory;

if ('DELETE' === $_SERVER['REQUEST_METHOD']) {
    $service = new TicketService(new TicketRepository(new MysqlDbFactory()));
    $service->deleteTicket($_GET['ticketId']);
}
