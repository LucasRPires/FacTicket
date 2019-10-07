<?php

require '../../vendor/autoload.php';

use App\Services\Concrete\TicketService;
use Infraestructure\Repositories\Concrete\TicketRepository;
use Infraestructure\Setup\DBContext\MysqlDbFactory;
use App\Validators\Concrete\TicketValidator;

$validator = new TicketValidator();

if ('PUT' === $_SERVER['REQUEST_METHOD']) {
    parse_str(file_get_contents('php://input'), $_PUT);

    if ($validator->validate($_PUT['ticket'])) {
        $service = new TicketService(new TicketRepository(new MysqlDbFactory()));
        $service->updateTicket($_PUT['ticket']);
    } else {
        $validator->errorValidate();
    }
}
