<?php

namespace App\Repositories\V1;

interface SMSSendingInterface
{
    /**
     * Send SMS
     *
     * @access public
     * @param int    $toNumber
     * @param string $body
     * @param string $mediaLink
     * @return string
     */
    public function sendSMS($toNumber, $body, $mediaLink);
}
