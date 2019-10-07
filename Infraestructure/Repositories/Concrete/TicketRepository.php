<?php

namespace Infraestructure\Repositories\Concrete;

use Infraestructure\Repositories\Contract\ITicketRepository;
use Infraestructure\Setup\Contract\IDBContext;
use Domain\Ticket;
use Domain\Client;
use Domain\Reason;

class TicketRepository implements ITicketRepository
{

    private static $conn;

    function __construct(IDBContext $context)
    {
        self::$conn = $context->connect();
    }

    public function add(Ticket $ticket): bool
    {
        $stmt = self::$conn->prepare("INSERT INTO Ticket (Description, Date_Created, Status, IdClient, IdReason) values (?,?,?,?,?)");
        $stmt->bind_param("ssiii", $ticket->description, $ticket->dateOpen, $ticket->status, $ticket->client, $ticket->reason);
        $execute = $stmt->execute();
        $stmt->close();

        if ($execute) {
            return true;
        } else {
            throw new Exception("Problemas ao adicionar Ticket");
        }
    }

    public function getAll(): array
    {

        $stmt = self::$conn->prepare("SELECT t.Id, t.Description, t.Date_Created, t.Date_Closed, t.Status, r.Id as reasonId, r.Name as reasonName, c.Id as clientId, c.Name as clientName 
                                      FROM Ticket t, Reason r, Client c 
                                      WHERE r.Id = t.IdReason AND c.Id = t.IdClient ORDER BY t.Id");
        $stmt->execute();
        $result = $stmt->get_result();
        $tickets = [];

        while ($data = $result->fetch_assoc()) {
            $ticket = new Ticket(
                new Client($data['clientId'], $data['clientName']),
                new Reason($data['reasonId'], $data['reasonName']),
                $data['Date_Created'],
                $data['Description'],
                $data['Status'],
                $data['Id'],
                $data['Date_Closed']
            );
            array_push($tickets, $ticket);
        }
        return $tickets;
    }

    public function update(Ticket $ticket): bool
    {
        $stmt = self::$conn->prepare("UPDATE Ticket set Description = ?, Date_Created = ?, Date_Closed = ?, Status = ?, idClient = ?, IdReason = ? WHERE Id = ?");
        $stmt->bind_param("sssiiii", $ticket->description, $ticket->dateOpen, $ticket->dateClosed, $ticket->status, $ticket->client->id, $ticket->reason->id, $ticket->id);
        $stmt->execute();
        $result = self::$conn->affected_rows;
        $stmt->close();

        if ($result > 0) {
            return true;
        } else {
            throw new Exception("Problemas ao atualizar Ticket");
        }
    }

    public function delete($idTicket): bool
    {
        $stmt = self::$conn->prepare("DELETE FROM Ticket WHERE Id = ?");
        $stmt->bind_param("i", $idTicket);
        $stmt->execute();
        $result = self::$conn->affected_rows;
        $stmt->close();

        if ($result > 0) {
            return true;
        } else {
            throw new Exception("Problemas ao deletar Ticket");
        }
    }
}
