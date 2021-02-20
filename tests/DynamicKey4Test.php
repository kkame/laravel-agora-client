<?php

namespace Tests;

use Kkame\Agora\DynamicKey4;

class DynamicKey4Test extends TestCase
{
    /**
     * @test
     */
    public function recordingKey()
    {
        $appID = env('appID');
        $appCertificate = env('appCertificate');
        $channelName = env('channelName');
        $ts = env('ts');
        $randomInt = env('randomInt');
        $uid = env('uid');
        $expiredTs = env('expiredTs');

        $expected = '004e0c24ac56aae05229a6d9389860a1a0e25e56da8970ca35de60c44645bbae8a215061b3314464554720383bbf51446455471';

        $actual = DynamicKey4::generateRecordingKey($appID, $appCertificate, $channelName, $ts, $randomInt, $uid, $expiredTs);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function mediaChannelKey()
    {
        $appID = env('appID');
        $appCertificate = env('appCertificate');
        $channelName = env('channelName');
        $ts = env('ts');
        $randomInt = env('randomInt');
        $uid = env('uid');
        $expiredTs = env('expiredTs');


        $expected = '004d0ec5ee3179c964fe7c0485c045541de6bff332b970ca35de60c44645bbae8a215061b3314464554720383bbf51446455471';

        $actual = DynamicKey4::generateMediaChannelKey($appID, $appCertificate, $channelName, $ts, $randomInt, $uid, $expiredTs);

        $this->assertEquals($expected, $actual);
    }
}
