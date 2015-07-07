<?php

namespace FPWeb\Test;

use FPWeb\Response;
use FPWeb\Route;

class RouteTest extends \PHPUnit_Framework_TestCase
{
    protected $basicResult  = null;
    protected $basicPattern = null;
    protected $basicHandler = null;
    protected $basicRequest = null;
    protected $basicRoutes  = null;

    protected function setup()
    {
        $text = 'basicHandler';
        $response = Response\create();
        $response['body'] = $text;
        $this->basicResult  = $response;
        $this->basicPattern = '/test';
        $this->basicHandler = function ($conn) use ($text) {
            $conn['response']['body'] = $text;
            return $conn;
        };
        $this->basicRequest = [
            'uri'    => trim($this->basicPattern, '/'),
            'server' => ['REQUEST_METHOD' => 'GET'],
            'params' => [],
        ];
        $this->basicRoutes  = [
            Route\get($this->basicPattern, $this->basicHandler),
        ];
    }

    public function testMatchBasicMatch()
    {
        $result = Route\match($this->basicRequest, $this->basicRoutes);
        $pattern = trim($this->basicPattern, '/');

        $this->assertNotNull($result);
        $this->assertEquals($result[0], Route\FOUND);
        $this->assertEquals($result[1]['pattern'], $pattern);
        $this->assertEquals($result[1]['callback'], $this->basicHandler);
        $this->assertEquals($result[1]['options'], ['method' => 'GET']);
    }

    public function testMatchBasicMatchNoMethod()
    {
        $request = $this->basicRequest;
        $request['server']['REQUEST_METHOD'] = 'POST';
        $result = Route\match($request, $this->basicRoutes);

        $this->assertNotNull($result);
        $this->assertEquals($result[0], Route\METHOD_NOT_ALLOWED);
    }

    public function testMatchBasicNoMatch()
    {
        $request = $this->basicRequest;
        $request['uri'] = 'no-match';
        $result = Route\match($request, $this->basicRoutes);

        $this->assertNotNull($result);
        $this->assertEquals($result[0], Route\NOT_FOUND);
    }

    public function testCreateBasic()
    {
        $route = Route\create($this->basicPattern, $this->basicHandler);
        $pattern = trim($this->basicPattern, '/');

        $this->assertNotNull($route);
        $this->assertEquals($route['pattern'], $pattern);
        $this->assertEquals($route['callback'], $this->basicHandler);
        $this->assertEquals($route['options'], []);
    }

    public function testCreateBasicWithOptions()
    {
        $route = Route\create(
            $this->basicPattern,
            $this->basicHandler,
            ['method' => 'GET']
        );
        $pattern = trim($this->basicPattern, '/');

        $this->assertNotNull($route);
        $this->assertEquals($route['pattern'], $pattern);
        $this->assertEquals($route['callback'], $this->basicHandler);
        $this->assertEquals($route['options'], ['method' => 'GET']);
    }

    public function testGetBasic()
    {
        $route = Route\get($this->basicPattern, $this->basicHandler);
        $pattern = trim($this->basicPattern, '/');

        $this->assertNotNull($route);
        $this->assertEquals($route['pattern'], $pattern);
        $this->assertEquals($route['callback'], $this->basicHandler);
        $this->assertEquals($route['options'], ['method' => 'GET']);
    }

    public function testPostBasic()
    {
        $route = Route\post($this->basicPattern, $this->basicHandler);
        $pattern = trim($this->basicPattern, '/');

        $this->assertNotNull($route);
        $this->assertEquals($route['pattern'], $pattern);
        $this->assertEquals($route['callback'], $this->basicHandler);
        $this->assertEquals($route['options'], ['method' => 'POST']);
    }

    public function testPutBasic()
    {
        $route = Route\put($this->basicPattern, $this->basicHandler);
        $pattern = trim($this->basicPattern, '/');

        $this->assertNotNull($route);
        $this->assertEquals($route['pattern'], $pattern);
        $this->assertEquals($route['callback'], $this->basicHandler);
        $this->assertEquals($route['options'], ['method' => 'PUT']);
    }

    public function testPatchBasic()
    {
        $route = Route\patch($this->basicPattern, $this->basicHandler);
        $pattern = trim($this->basicPattern, '/');

        $this->assertNotNull($route);
        $this->assertEquals($route['pattern'], $pattern);
        $this->assertEquals($route['callback'], $this->basicHandler);
        $this->assertEquals($route['options'], ['method' => 'PATCH']);
    }

    public function testDeleteBasic()
    {
        $route = Route\delete($this->basicPattern, $this->basicHandler);
        $pattern = trim($this->basicPattern, '/');

        $this->assertNotNull($route);
        $this->assertEquals($route['pattern'], $pattern);
        $this->assertEquals($route['callback'], $this->basicHandler);
        $this->assertEquals($route['options'], ['method' => 'DELETE']);
    }

    public function testOptionsBasic()
    {
        $route = Route\options($this->basicPattern, $this->basicHandler);
        $pattern = trim($this->basicPattern, '/');

        $this->assertNotNull($route);
        $this->assertEquals($route['pattern'], $pattern);
        $this->assertEquals($route['callback'], $this->basicHandler);
        $this->assertEquals($route['options'], ['method' => 'OPTIONS']);
    }

    public function testTraceBasic()
    {
        $route = Route\trace($this->basicPattern, $this->basicHandler);
        $pattern = trim($this->basicPattern, '/');

        $this->assertNotNull($route);
        $this->assertEquals($route['pattern'], $pattern);
        $this->assertEquals($route['callback'], $this->basicHandler);
        $this->assertEquals($route['options'], ['method' => 'TRACE']);
    }
}
