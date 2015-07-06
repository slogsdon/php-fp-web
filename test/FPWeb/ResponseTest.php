<?php

namespace FPWeb\Test;

use FPWeb\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateBasic()
    {
        $result = Response\create();

        $this->assertNotNull($result);
        $this->assertEquals($result['body'], '');
        $this->assertEquals($result['headers'], []);
        $this->assertEquals($result['status'], 200);
        $this->assertEquals($result['assigns'], []);
    }
}
