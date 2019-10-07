<?php

namespace App\Validators\Concrete;

use App\Validators\Contract\IBaseValidator;

class TicketValidator extends IBaseValidator
{

    public function validate($postedTicket): bool
    {
        if ($postedTicket['client'] <= 0)
            return false;

        if ($postedTicket['reason'] <= 0)
            return false;

        if ($postedTicket['description'] == '' || $postedTicket['description'] == null)
            return false;

        if (gettype((bool) $postedTicket['status']) != 'boolean')
            return false;

        return true;
    }
}
