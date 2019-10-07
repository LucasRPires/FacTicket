<?php

namespace App\Services\Concrete;

use App\Services\Contracts\BaseService;
use Infraestructure\Repositories\Contract\ITicketRepository;
use Domain\Ticket;
use Domain\Client;
use Domain\Reason;
use Exception;

date_default_timezone_set('America/Sao_Paulo');

class TicketService extends BaseService
{

    private $respository;

    function __construct(ITicketRepository $repository)
    {
        $this->repository = $repository;
    }

    public function addTicket($postedTicket)
    {
        try {
            $ticket = new Ticket((int) $postedTicket['client'], (int) $postedTicket['reason'], date('Y-m-d h:i:s', time()), $postedTicket['description'], $postedTicket['status'] == 'true' ? true : false);
            $this->resolve($this->repository->add($ticket));
        } catch (Exception $e) {
            $this->reject($e->getMessage());
        }
    }

    public function updateTicket($postedTicket)
    {
        try {
            $ticket = new Ticket(
                new Client((int) $postedTicket['client']['id'], $postedTicket['client']['name']),
                new Reason((int) $postedTicket['reason']['id'], $postedTicket['reason']['name']),
                $postedTicket['dateOpen'],
                $postedTicket['description'],
                $postedTicket['status'] == 'true' ? true : false,
                (int) $postedTicket['id'],
                $postedTicket['dateClosed'] == '' ? null : $postedTicket['dateClosed']
            );

            $this->resolve($this->repository->update($ticket));
        } catch (Exception $e) {
            $this->reject($e->getMessage());
        }
    }

    public function deleteTicket($id)
    {
        try {
            $this->resolve($this->repository->delete($id));
        } catch (Exception $e) {
            $this->reject($e->getMessage());
        }
    }

    public function getAllTickets()
    {
        try {
            $this->resolve($this->repository->getAll());
        } catch (Exception $e) {
            $this->reject($e->getMessage());
        }
    }
}
