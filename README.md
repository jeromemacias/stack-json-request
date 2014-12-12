JSON Request Stack middleware
=============================

JsonRequest stack middleware transform raw JSON request content by request data of decoded JSON.

Installation
------------

```bash
composer require jeromemacias/stack-json-request ~1.0@dev
```

Usage
-----

```php
use Stack;
use Stack\JsonRequest;

$app = ...;

$app = new JsonRequest($app);
```