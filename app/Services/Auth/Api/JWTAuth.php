<?php

namespace Dsc\Services\Auth\Api;

class JWTAuth extends \Tymon\JWTAuth\JWTAuth
{
    use ExtendsJwtValidation;
}
