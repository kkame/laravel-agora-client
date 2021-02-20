<?php

namespace Kkame\Agora;

class SignalingToken
{
    public const SDK_VERSION = "1";

    public static function getToken($appid, $appcertificate, $account, $validTimeInSeconds): string
    {
        $expiredTime = time() + $validTimeInSeconds;

        $token_items = [];
        array_push($token_items, self::SDK_VERSION);
        array_push($token_items, $appid);
        array_push($token_items, $expiredTime);
        array_push($token_items, md5($account . $appid . $appcertificate . $expiredTime));
        return join(":", $token_items);
    }
}
