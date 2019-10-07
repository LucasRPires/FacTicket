<?php

namespace App\Services\Concrete;

use App\Services\Contracts\BaseService;
use Infraestructure\Repositories\Contract\IReasonRepository;

class ReasonService extends BaseService
{

    private $respository;

    function __construct(IReasonRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllReasons()
    {
        try {
            $this->resolve($this->repository->getAll());
        } catch (Exception $e) {
            $this->reject("Problemas ao carregar os Motivos");
        }
    }
}
