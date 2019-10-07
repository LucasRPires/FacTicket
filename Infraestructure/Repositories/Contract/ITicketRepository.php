<?php

namespace Infraestructure\Repositories\Contract;

use Domain\Ticket;

interface ITicketRepository
{
    public function add(Ticket $ticket): bool;

    public function getAll(): array;

    public function update(Ticket $ticket): bool;

    public function delete($idTicket): bool;
}
