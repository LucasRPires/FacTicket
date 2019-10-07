<?php

namespace App\Validators\Contract;

abstract class IBaseValidator
{
    abstract function validate($postedTicket);

    public function errorValidate()
    {
        echo json_encode("Problemas com os valores informados");
    }
}
