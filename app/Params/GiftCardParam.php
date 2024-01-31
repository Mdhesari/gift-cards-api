<?php

namespace App\Params;

class GiftCardParam
{
    public function __construct(
        public readonly string $code,
        public readonly string $mobile,
    )
    {
        //
    }
}
