<?php

namespace App\Services\Concrete;

use App\Services\Contracts\BaseService;
use Infraestructure\Repositories\Contract\IClientRepository;

class ClientService extends BaseService
{

    private $respository;

    function __construct(IClientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllClients()
    {
        try {
            $this->resolve($this->repository->getAll());
        } catch (Exception $e) {
            throw new Exception("Problemas ao carregar os Clientes");
        }
    }
}
