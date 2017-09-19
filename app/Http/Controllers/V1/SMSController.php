<?php

namespace App\Http\Controllers\V1;

use App\Models\V1\SMSQueuing;
use App\Helpers\JsendResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SMSRequest;

class SMSController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SMSQueuing $smsModel)
    {
        $this->smsQueueModel = $smsModel;
    }

    public function sendOrderSMS(SMSRequest $request)
    {
        $data  = $request->all();
        $this->smsQueueModel->queue($data);

        /*
         * @todo: Use Transformer for response: https://github.com/spatie/laravel-fractal
         */
        return JsendResponse::make(null, 'SMS Queued Successfully');
    }
}
