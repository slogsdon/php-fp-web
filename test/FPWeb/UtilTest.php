<?php

namespace FPWeb\Test;

use FPWeb\Util;

class UtilTest extends \PHPUnit_Framework_TestCase
{
    public function testPipeEmptyPipeline()
    {
        $pipeline = [];
        $initial = null;
        $result = Util\pipe($pipeline, $initial);

        $this->assertEquals($result, $initial);
    }

    public function testPipeFunctionNoAdditionalArguments()
    {
        $f1 = function ($current) {
            return 'f1';
        };
        $pipeline = [
            [$f1],
        ];
        $initial = null;
        $result = Util\pipe($pipeline, $initial);

        $this->assertNotEquals($result, $initial);
        $this->assertEquals($result, 'f1');
    }

    public function testPipeFunctionAdditionalArguments()
    {
        $f1 = function ($current, $arg) {
            return $arg;
        };
        $pipeline = [
            [$f1, array('f1')],
        ];
        $initial = null;
        $result = Util\pipe($pipeline, $initial);

        $this->assertNotEquals($result, $initial);
        $this->assertEquals($result, 'f1');
    }

    public function testResetHeaders()
    {
        $result = Util\resetHeaders();

        $this->assertNotNull($result);
        $this->assertTrue(is_bool($result));
    }

    public function testResetHeadersForced()
    {
        $result = Util\resetHeaders(true);

        $this->assertNotNull($result);
        $this->assertTrue(is_bool($result));
    }
}
