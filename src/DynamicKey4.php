<?php

namespace Kkame\Agora;

class DynamicKey4
{
    public static function generateRecordingKey(
        $appID,
        $appCertificate,
        $channelName,
        $ts,
        $randomInt,
        $uid,
        $expiredTs,
        $serviceType = 'ARS'
    ): string {
        return self::generateDynamicKey(
            $appID,
            $appCertificate,
            $channelName,
            $ts,
            $randomInt,
            $uid,
            $expiredTs,
            $serviceType
        );
    }

    public static function generateMediaChannelKey(
        $appID,
        $appCertificate,
        $channelName,
        $ts,
        $randomInt,
        $uid,
        $expiredTs,
        $serviceType = 'ACS'
    ): string {
        return self::generateDynamicKey(
            $appID,
            $appCertificate,
            $channelName,
            $ts,
            $randomInt,
            $uid,
            $expiredTs,
            $serviceType
        );
    }

    public static function generateDynamicKey(
        $appID,
        $appCertificate,
        $channelName,
        $ts,
        $randomInt,
        $uid,
        $expiredTs,
        $serviceType
    ): string {
        $version = "004";

        $randomStr = "00000000" . dechex($randomInt);
        $randomStr = substr($randomStr, -8);

        $uidStr = "0000000000" . $uid;
        $uidStr = substr($uidStr, -10);

        $expiredStr = "0000000000" . $expiredTs;
        $expiredStr = substr($expiredStr, -10);

        $signature = self::generateSignature(
            $appID,
            $appCertificate,
            $channelName,
            $ts,
            $randomStr,
            $uidStr,
            $expiredStr,
            $serviceType
        );

        return $version . $signature . $appID . $ts . $randomStr . $expiredStr;
    }

    public static function generateSignature(
        $appID,
        $appCertificate,
        $channelName,
        $ts,
        $randomStr,
        $uidStr,
        $expiredStr,
        $serviceType
    ): string {
        $concat = $serviceType . $appID . $ts . $randomStr . $channelName . $uidStr . $expiredStr;
        return hash_hmac('sha1', $concat, $appCertificate);
    }
}
