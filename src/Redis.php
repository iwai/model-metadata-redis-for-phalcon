<?php
/**
 * Redis.php
 *
 * @version     $Id$
 *
 */


namespace Iwai\Phalcon\Mvc\Model\MetaData;

use \Redis as PhpRedis;
use Phalcon\Mvc\Model\MetaData;

class Redis extends MetaData {

    const DEFAULT_TTL = 3600;

    private $_options = [ ];
    private $_cache   = [ ];
    private $_client  = null;

    public function __construct($options = array())
    {
        $this->_options = $options;

        if (!isset($this->_options['prefix']))
            $this->_options['prefix'] = '__metadata';
        if (!isset($this->_options['lifetime']))
            $this->_options['lifetime'] = self::DEFAULT_TTL;

        $this->_metaData = [];
    }

    private function getClient()
    {
        if (!isset($this->_client)) {
            $client = new PhpRedis();
            $client->pconnect(
                $this->_options['host'], $this->_options['port'], 0, gethostname()
            );
            $client->setOption(PhpRedis::OPT_SERIALIZER, PhpRedis::SERIALIZER_PHP);
            $client->select(0);

            $this->_client = $client;
        }
        return $this->_client;
    }

    public function read($key)
    {
        if (isset($this->_cache[ $key ]))
            return $this->_cache[ $key ];

        try {
            if (false === ($value = $this->getClient()->hGet($this->_options['prefix'], $key)))
                return null;
            return $value;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function write($key, $data)
    {
        $this->_cache[ $key ] = $data;

        try {
            $this->getClient()->hSet($this->_options['prefix'], $key, $data);

            if ($this->_options['lifetime'] > 0)
                $this->getClient()->setTimeout(
                    $this->_options['prefix'], $this->_options['lifetime']
                );
        } catch (\Exception $e) {

        }
    }

    public function reset()
    {
        try {
            $keys = $this->getClient()->hGetAll($this->_options['prefix']);

            if (is_array($keys)) {
                foreach ($keys as $k) {
                    $this->getClient()->hDel($this->_options['prefix'], $k);
                }
            }
        } catch (\Exception $e) {

        }
        parent::reset();
    }

}