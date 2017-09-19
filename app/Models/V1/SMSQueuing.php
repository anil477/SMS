<?php

namespace App\Models\V1;

use Psr\Log\LoggerInterface;
use App\Events\V1\SendOrderSmsEvent;
use Illuminate\Contracts\Events\Dispatcher;

class SMSQueuing
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $log, Dispatcher $dispatch)
    {
        $this->logger      = $log;
        $this->dispatcher  = $dispatch;
    }

    /**
     * @param string $uID
     * @param string $orderId
     * @return collection
     * @throws InvalidUserException
     * @throws InvalidOrderException
     */
    public function queue($data)
    {
        // @todo: to prevent multiple events for the same task being queued
        // store the hash for $uId.$orderId.$number in redis for like 24 hours

        $media = data_get($data, 'media', null);

        // Dispatch the task
        $this->dispatcher->dispatch(new SendOrderSmsEvent(
            $data['number'],
            $data['body'],
            $data['media'],
            $data['u_id'],
            $data['order_id']
        ));
        $this->logger->info('order.placed.sms.notification.queued', ['uID' => $data['u_id'], 'orderId' => $data['order_id']]);
    }
}
