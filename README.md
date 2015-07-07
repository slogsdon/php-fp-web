# fp-web

[![Packagist Version](https://img.shields.io/packagist/v/slogsdon/fp-web.svg)]](https://packagist.org/packages/slogsdon/fp-web)
[![Build Status](https://img.shields.io/travis/slogsdon/php-fp-web.svg?style=flat)](https://travis-ci.org/slogsdon/php-fp-web)
[![Coverage Status](https://img.shields.io/coveralls/slogsdon/php-fp-web.svg?style=flat)](https://coveralls.io/r/slogsdon/php-fp-web)

> Test bed for a functional web toolkit

This is just an experiment for what a web toolkit that doesn't use
object-oriented code.

In theory, this is just a bit of PHP and should be fine for use, but in
practice, don't use this but use something more established, more tested, and
more used instead.

## Running the example

```
$ git clone https://github.com/slogsdon/php-fp-web
$ cd php-fp-web
$ composer install
$ php -S 0.0.0.0:8888 -t example
```

In another terminal session:

```
$ curl -i http://localhost:8800/index
HTTP/1.1 200 OK
Host: localhost:8888
Connection: close
X-Powered-By: PHP/5.6.10
Content-type: text/html; charset=UTF-8

index
$ curl -i http://localhost:8800/
HTTP/1.1 404 Not Found
Host: localhost:8888
Connection: close
X-Powered-By: PHP/5.6.10
Content-type: text/html; charset=UTF-8

Not Found
```

## Usage

```php
<?php
require 'vendor/autoload.php';

use \FPWeb\App;
use \FPWeb\Route;

// index handler
$index = function ($conn) {
    // TODO: make this process nicer
    $conn['response']['body'] = 'index';
    return $conn;
};

// create routes
$routes = [
    Route\get('/index', $index),
];

// match request and run match
$response = App\run($routes, [
    'param_set' => [$_GET, $_POST],
    'on_error' => function ($conn) {
        $conn['response']['body'] = 'Not Found';
        return $conn;
    },
]);

printf('<pre><code>%s</code></pre>', print_r($response, true));
```
