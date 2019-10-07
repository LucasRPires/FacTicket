<?php

require '../../vendor/autoload.php';

use App\Services\Concrete\TicketService;
use Infraestructure\Repositories\Concrete\TicketRepository;
use Infraestructure\Setup\DBContext\MysqlDbFactory;
use App\Validators\Concrete\TicketValidator;

$validator = new TicketValidator();

if ($validator->validate($_POST['ticket'])) {
    $service = new TicketService(new TicketRepository(new MysqlDbFactory()));
    $service->addTicket($_POST['ticket']);
} else {
    $validator->errorValidate();
}
