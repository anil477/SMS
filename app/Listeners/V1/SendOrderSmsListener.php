<?php

namespace App\Listeners\V1;

use Exception;
use Psr\Log\LoggerInterface;
use App\Events\V1\SendOrderSmsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\V1\SMSSendingInterface;
use App\Repositories\V1\SMSLoggingInterface;

class SendOrderSmsListener implements ShouldQueue
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var SMSSendingInterface
     */
    private $SMSClient;

    /**
     * @var SMSLoggingInterface
     */
    private $smsLogging;

    public function __construct(LoggerInterface $log, SMSSendingInterface $smsClient, SMSLoggingInterface $smsLogging)
    {
        $this->logger     = $log;
        $this->SMSClient  = $smsClient;
        $this->smsLogging = $smsLogging;
    }

    public function handle(SendOrderSmsEvent $event)
    {
        try {
            $response = $this->SMSClient->sendSMS($event->getNumber(), $event->getBody(), $event->getMedia());
            $this->smsLogging->log($event->getNumber(), $event->getOrderId(), $response);
        } catch (Exception $e) {
            $this->logger->error('sms.service.exception', ['error_message' => $e->getMessage()]);
        }
    }
}
