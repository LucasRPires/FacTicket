<?php

namespace Test\Ticket;

use PHPUnit\Framework\TestCase;
use Infraestructure\Repositories\Concrete\TicketRepository;
use Infraestructure\Setup\DBContext\MysqlDbFactory;
use Domain\Ticket;
use Domain\Client;
use Domain\Reason;

class DBContextTest extends TestCase
{

    public function testDeleteTicketIfNotExists()
    {
        $repository = new TicketRepository(new MysqlDbFactory());
        $this->assertEquals(false, $repository->delete(28));
    }

    public function testDeleteTicketIfExists()
    {
        $repository = new TicketRepository(new MysqlDbFactory());
        $this->assertEquals(true, $repository->delete(13));
    }

    public function testUpdateTicketIfNotExists()
    {
        $service = new TicketRepository(new MysqlDbFactory());
        $ticket = new Ticket(new Client(2, 'Shoptime'), new Reason(1, 'Problema no sistema'), date('Y-m-d'), 'teste', '1', 1779);
        $this->assertEquals(false, $service->update($ticket));
    }

    public function testUpdateTicketIfExists()
    {
        $service = new TicketRepository(new MysqlDbFactory());
        $ticket = new Ticket(new Client(2, 'Shoptime'), new Reason(1, 'Problema no sistema'), date('Y-m-d'), 'teste', '1', 25);
        $this->assertEquals(true, $service->update($ticket));
    }
}
