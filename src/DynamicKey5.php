<?php

namespace Kkame\Agora;

class DynamicKey5
{
    public const VERSION = "005";
    public const NO_UPLOAD = "0";
    public const AUDIO_VIDEO_UPLOAD = "3";

    // InChannelPermissionKey
    public const ALLOW_UPLOAD_IN_CHANNEL = 1;

    // Service Type
    public const MEDIA_CHANNEL_SERVICE = 1;
    public const RECORDING_SERVICE = 2;
    public const PUBLIC_SHARING_SERVICE = 3;
    public const IN_CHANNEL_PERMISSION = 4;

    public static function generateRecordingKey(
        $appID,
        $appCertificate,
        $channelName,
        $ts,
        $randomInt,
        $uid,
        $expiredTs
    ): string {
        return self::generateDynamicKey(
            $appID,
            $appCertificate,
            $channelName,
            $ts,
            $randomInt,
            $uid,
            $expiredTs,
            self::RECORDING_SERVICE,
            []
        );
    }

    public static function generateMediaChannelKey(
        $appID,
        $appCertificate,
        $channelName,
        $ts,
        $randomInt,
        $uid,
        $expiredTs
    ): string {
        return self::generateDynamicKey(
            $appID,
            $appCertificate,
            $channelName,
            $ts,
            $randomInt,
            $uid,
            $expiredTs,
            self::MEDIA_CHANNEL_SERVICE,
            []
        );
    }

    public static function generateInChannelPermissionKey(
        $appID,
        $appCertificate,
        $channelName,
        $ts,
        $randomInt,
        $uid,
        $expiredTs,
        $permission
    ): string {
        $extra[self::ALLOW_UPLOAD_IN_CHANNEL] = $permission;
        return self::generateDynamicKey(
            $appID,
            $appCertificate,
            $channelName,
            $ts,
            $randomInt,
            $uid,
            $expiredTs,
            self::IN_CHANNEL_PERMISSION,
            $extra
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
        $serviceType,
        $extra
    ): string {
        $signature = self::generateSignature(
            $serviceType,
            $appID,
            $appCertificate,
            $channelName,
            $uid,
            $ts,
            $randomInt,
            $expiredTs,
            $extra
        );
        $content = self::packContent($serviceType, $signature, hex2bin($appID), $ts, $randomInt, $expiredTs, $extra);
        // echo bin2hex($content);
        return self::VERSION . base64_encode($content);
    }

    public static function generateSignature(
        $serviceType,
        $appID,
        $appCertificate,
        $channelName,
        $uid,
        $ts,
        $salt,
        $expiredTs,
        $extra
    ): string {
        $rawAppID = hex2bin($appID);
        $rawAppCertificate = hex2bin($appCertificate);

        $buffer = pack("S", $serviceType);
        $buffer .= pack("S", strlen($rawAppID)) . $rawAppID;
        $buffer .= pack("I", $ts);
        $buffer .= pack("I", $salt);
        $buffer .= pack("S", strlen($channelName)) . $channelName;
        $buffer .= pack("I", $uid);
        $buffer .= pack("I", $expiredTs);

        $buffer .= pack("S", count($extra));
        foreach ($extra as $key => $value) {
            $buffer .= pack("S", $key);
            $buffer .= pack("S", strlen($value)) . $value;
        }

        return strtoupper(hash_hmac('sha1', $buffer, $rawAppCertificate));
    }

    public static function packString(
        $value
    ): string {
        return pack("S", strlen($value)) . $value;
    }

    public static function packContent($serviceType, $signature, $appID, $ts, $salt, $expiredTs, $extra): string
    {
        $buffer = pack("S", $serviceType);
        $buffer .= self::packString($signature);
        $buffer .= self::packString($appID);
        $buffer .= pack("I", $ts);
        $buffer .= pack("I", $salt);
        $buffer .= pack("I", $expiredTs);

        $buffer .= pack("S", count($extra));
        foreach ($extra as $key => $value) {
            $buffer .= pack("S", $key);
            $buffer .= self::packString($value);
        }

        return $buffer;
    }
}
