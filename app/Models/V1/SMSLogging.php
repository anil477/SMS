<?php

namespace App\Models\V1\Mail;

use Psr\Log\LoggerInterface;
use App\Repositories\V1\SMSLoggingInterface;

class SMSLogging implements SMSLoggingInterface
{
    public function __construct(LoggerInterface $log)
    {
        $this->logger = $log;
    }

    /**
     * Log the response from Mail Service
     *
     * @access public
     * @param  string  $uId (can be uuid)
     * @param  orderId $orderId (can be uuid)
     * @param  array   $data
     */
    public function log($uId, $orderId, $response)
    {
        /*
         * @todo: Log the response from the Mail Service.
         * The DB can be a separate DB server just for logging
         * It's good not to use the Master DB for these logging write
         */
        $this->logger->info('sms.service.log', [
                'uid' => $uId,
                'order' => $orderId,
                'res' => $response
        ]);

        return true;
    }
}
