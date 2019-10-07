<?php

namespace Infraestructure\Repositories\Concrete;

use Infraestructure\Repositories\Contract\IClientRepository;
use Infraestructure\Setup\Contract\IDBContext;
use Domain\Client;

class ClientRepository implements IClientRepository
{
    private static $conn;

    function __construct(IDBContext $context)
    {
        self::$conn = $context->connect();
    }

    public function getAll(): array
    {
        $stmt = self::$conn->prepare("SELECT * FROM Client");
        $stmt->execute();
        $result = $stmt->get_result();
        $clients = [];

        while ($data = $result->fetch_assoc()) {
            $client = new Client($data['Id'], $data['Name']);
            array_push($clients, $client);
        }
        return $clients;
    }
}
