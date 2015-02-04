# model-metadata-redis-for-phalcon
Adapt to Redis the model metadata of Phalcon

# Usage

```php

use Phalcon\Mvc\Application;
use Iwai\Phalcon\Mvc\Model\MetaData\Redis as MetaDataRedis;

$app = new Application();

$app->getDI()->setShared('modelsMetadata', function () {
    return new MetaDataRedis([
        'host' => '127.0.0.1',
        'port' => 6379,
    ]);
});

```

# Options

## host
  Redis server host
## port
  Redis server port
## prefix
  Set hset prefix key for Redis (default `__metadata`)
## lifetime
  Set timeout for cache (default 3600 sec)
