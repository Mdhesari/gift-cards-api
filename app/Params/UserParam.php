<?php

namespace App\Params;

class UserParam
{
    public function __construct(
        public readonly string $mobile,
        public readonly ?string $name = null,
        public readonly ?string $password = null,
    )
    {
        //
    }
}
