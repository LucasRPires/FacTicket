<?php

namespace Infraestructure\Repositories\Concrete;

use Infraestructure\Repositories\Contract\IReasonRepository;
use Infraestructure\Setup\Contract\IDBContext;
use Domain\Reason;

class ReasonRepository implements IReasonRepository
{
    private static $conn;

    function __construct(IDBContext $context)
    {
        self::$conn = $context->connect();
    }

    public function getAll(): array
    {
        $stmt = self::$conn->prepare("SELECT * FROM Reason");
        $stmt->execute();
        $result = $stmt->get_result();
        $reasons = [];

        while ($data = $result->fetch_assoc()) {
            $reason = new Reason($data['Id'], $data['Name']);
            array_push($reasons, $reason);
        }
        return $reasons;
    }
}
