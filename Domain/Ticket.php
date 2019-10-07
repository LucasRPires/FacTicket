<?php

namespace Domain;

class Ticket
{
    public $id;
    public $client;
    public $reason;
    public $dateOpen;
    public $dateClosed;
    public $description;
    public $status;

    function __construct($client, $reason, $dateOpen, $description, $status, $id = null, $dateClosed = null)
    {
        $this->id = $id;
        $this->client = $client;
        $this->reason = $reason;
        $this->dateOpen = $dateOpen;
        $this->dateClosed = $dateClosed;
        $this->description = $description;
        $this->status = $status;
    }
}
