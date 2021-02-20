<?php

namespace Tests;

use Kkame\Agora\DynamicKey5;

class DynamicKey5Test extends TestCase
{
    /**
     * @test
     */
    public function RecordingKey()
    {
        $appID = env('appID');
        $appCertificate = env('appCertificate');
        $channelName = env('channelName');
        $ts = env('ts');
        $randomInt = env('randomInt');
        $uid = env('uid');
        $expiredTs = env('expiredTs');

        $expected = "005AgAoADkyOUM5RTQ2MTg3QTAyMkJBQUIyNkI3QkYwMTg0MzhDNjc1Q0ZFMUEQAJcMo13mDERkW7roohUGGzOwKDdW9buDA68oN1YAAA==";
        $actual = DynamicKey5::generateRecordingKey(
            $appID,
            $appCertificate,
            $channelName,
            $ts,
            $randomInt,
            $uid,
            $expiredTs
        );

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function MediaChannelKey()
    {
        $appID = env('appID');
        $appCertificate = env('appCertificate');
        $channelName = env('channelName');
        $ts = env('ts');
        $randomInt = env('randomInt');
        $uid = env('uid');
        $expiredTs = env('expiredTs');

        $expected = "005AQAoAEJERTJDRDdFNkZDNkU0ODYxNkYxQTYwOUVFNTM1M0U5ODNCQjFDNDQQAJcMo13mDERkW7roohUGGzOwKDdW9buDA68oN1YAAA==";

        $actual = DynamicKey5::generateMediaChannelKey(
            $appID,
            $appCertificate,
            $channelName,
            $ts,
            $randomInt,
            $uid,
            $expiredTs
        );

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function InChannelPermission()
    {
        $appID = env('appID');
        $appCertificate = env('appCertificate');
        $channelName = env('channelName');
        $ts = env('ts');
        $randomInt = env('randomInt');
        $uid = env('uid');
        $expiredTs = env('expiredTs');

        $noUpload = "005BAAoADgyNEQxNDE4M0FGRDkyOEQ4REFFMUU1OTg5NTg2MzA3MTEyNjRGNzQQAJcMo13mDERkW7roohUGGzOwKDdW9buDA68oN1YBAAEAAQAw";
        $generatedNoUpload = DynamicKey5::generateInChannelPermissionKey(
            $appID,
            $appCertificate,
            $channelName,
            $ts,
            $randomInt,
            $uid,
            $expiredTs,
            DynamicKey5::NO_UPLOAD
        );
        $this->assertEquals($noUpload, $generatedNoUpload);

        $generatedAudioVideoUpload = DynamicKey5::generateInChannelPermissionKey(
            $appID,
            $appCertificate,
            $channelName,
            $ts,
            $randomInt,
            $uid,
            $expiredTs,
            DynamicKey5::AUDIO_VIDEO_UPLOAD
        );
        $this->assertEquals(
            "005BAAoADJERDA3QThENTE2NzJGNjQwMzY5NTFBNzE0QkI5NTc0N0Q1QjZGQjMQAJcMo13mDERkW7roohUGGzOwKDdW9buDA68oN1YBAAEAAQAz",
            $generatedAudioVideoUpload
        );
    }
}
