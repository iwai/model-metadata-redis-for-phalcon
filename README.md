# model-metadata-redis-for-phalcon
Adapt to Redis the model metadata of Phalcon

[![Latest Stable Version](https://poser.pugx.org/iwai/phalcon-model-metadata-redis-adapter/v/stable.svg)](https://packagist.org/packages/iwai/phalcon-model-metadata-redis-adapter) [![Total Downloads](https://poser.pugx.org/iwai/phalcon-model-metadata-redis-adapter/downloads.svg)](https://packagist.org/packages/iwai/phalcon-model-metadata-redis-adapter) [![Latest Unstable Version](https://poser.pugx.org/iwai/phalcon-model-metadata-redis-adapter/v/unstable.svg)](https://packagist.org/packages/iwai/phalcon-model-metadata-redis-adapter) [![License](https://poser.pugx.org/iwai/phalcon-model-metadata-redis-adapter/license.svg)](https://packagist.org/packages/iwai/phalcon-model-metadata-redis-adapter)

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
