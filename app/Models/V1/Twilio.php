<?php

namespace App\Models\V1;

use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Translation\Translator;
use App\Repositories\V1\SMSSendingInterface;
use App\Common\Exceptions\InputValidationException;

class Twilio implements SMSSendingInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Log
     */
    private $log;

    /**
     * @var Log
     */
    private $twilioNumber;

    public function __construct(Client $client, Log $log)
    {
        $this->log          = $log;
        $this->client       = $client;
        $this->twilioNumber = app()['config']->get('twilio')['number'];
    }

    /**
     * Send SMS
     *
     * @access public
     * @param  int    $toNumber
     * @param  string $body
     * @param  string $mediaLink
     * @return bool
     * @throws RestException
     */
    public function sendSMS($toNumber, $body, $mediaLink)
    {
        /*
         * @todo: Here we are handling the response and error in a very naive way.
         * This can be improvised upon as per requirement
         */
        try {
            $response = $this->client->messages->create(
                $toNumber,
                [
                    'from'     => $this->twilioNumber,
                    'body'     => $body,
                    'mediaUrl' => $mediaLink
                ]
            );

            return $message->sid;
        } catch (RestException $exception) {
            $this->log->error('sms.services.failure', [
                'exception'          => $exception,
                'twilio_status_code' => $exception->getStatusCode(),
                'message'            => $exception->getMessage(),
            ]);

            return null;
        }
    }
}
