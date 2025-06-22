<?php

namespace App\Helpers;

class ResponseHelper
{
    // SubStatus of HTTP Status 200
    const RESPONSE_STATUS_OK = 2000;


    // SubStatus of HTTP Status 400
    const RESPONSE_STATUS_UNAUTHORIZED= 4010;
    const RESPONSE_STATUS_ALREADY_HAVE_ACCOUNT = 4011;
    const RESPONSE_STATUS_FORBIDDEN = 4030;
}
