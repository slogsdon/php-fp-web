<?php
namespace FPWeb\Test;

use FPWeb\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testPrepareParamsSetContainsSuperglobals()
    {
        $set = [$_GET, $_POST];
        $params = Request\prepareParams($set);

        $this->assertNotNull($params);
    }

    public function testPrepareParamsEmptySet()
    {
        $set = [];
        $params = Request\prepareParams($set);

        $this->assertNotNull($params);
        $this->assertEquals($params, []);
    }

    public function testParseDefaults()
    {
        // REQUEST_URI isn't provided by php-cli :(
        $_SERVER['REQUEST_URI'] = '/';
        $request = Request\parse();

        $this->assertNotNull($request);
        $this->assertEquals($request['uri'], '');
        $this->assertEquals($request['server'], $_SERVER);
        $this->assertEquals($request['params'], []);
    }
}
