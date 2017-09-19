<?php

namespace App\Events\V1;

use App\Events\Event;

class SendOrderSmsEvent extends Event
{

    private $number;

    private $body;

    private $media;

    private $userId;

    private $orderId;

    public function __construct($number, $body, $media, $userId, $orderId)
    {
        $this->body    = $body;
        $this->media   = $media;
        $this->number  = $number;
        $this->userId  = $userId;
        $this->orderId = $orderId;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getMedia()
    {
        return $this->media;
    }
}
