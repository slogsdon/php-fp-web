<?php

namespace FPWeb\Test;

use FPWeb\App;
use FPWeb\Response;
use FPWeb\Route;

class AppTest extends \PHPUnit_Framework_TestCase
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
        $this->basicRoutes  = [
            Route\get($this->basicPattern, $this->basicHandler),
        ];

        $_SERVER['REQUEST_URI'] = $this->basicPattern;
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }

    public function testRunBasicMatch()
    {
        $result = App\run($this->basicRoutes);

        $this->assertNotNull($result);
        $this->assertEquals($result['response'], $this->basicResult);
    }

    public function testRunBasicNoMatch()
    {
        $_SERVER['REQUEST_URI'] = '/no-match';
        $result = App\run($this->basicRoutes, ['not_found' => function ($conn) {
            $conn['response']['body'] = 'not found';
            return $conn;
        }]);

        $this->assertNotNull($result);
        $this->assertEquals($result['response']['body'], 'not found');
    }
}
