<?php

namespace App\Repositories\V1;

interface SMSLoggingInterface
{
    /**
     * Log the response from SMS Sending Service
     *
     * @param  string  $uId (can be uuid)
     * @param  orderId $orderId (can be uuid)
     * @param  array   $data
     */
    public function log($uId, $orderId, $response);
}
