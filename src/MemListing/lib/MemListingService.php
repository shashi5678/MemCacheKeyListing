<?php
/**
 * @author : Shashi
 * This class will be used for Listing and deleting Memcached keys
 */
namespace MemListing\lib;

use Zend\Cache\StorageFactory;
use Zend\Session\SaveHandler\Cache;
use Zend\Http\Request;

class MemListingService
{

    protected static $saveHandler;

    public function __construct()
    {
        $server = '127.0.0.1';
        $port = 11211;
        
        $request = new \Zend\Http\PhpEnvironment\Request();
        $uri = new \Zend\Uri\Uri($request->getUri());
        $host = $uri->getHost();
        
        $cache = StorageFactory::factory(array(
            'adapter' => array(
                'name' => 'memcached',
                'options' => array(
                    'servers' => array(
                        array(
                            $server,
                            $port
                        )
                    ),
                    'namespace' => $host
                )
            )
        ));
        
        if (! self::$saveHandler) {
            self::$saveHandler = new Cache($cache);
        }
    }
    /**
     * funtion to get cached keys
     * @return array
     */

    public function getMemcacheKeys()
    {
        $memcachedObj = $this->getMemcachedObj();
        $allKeys = $memcachedObj->getAllKeys();
        
        $list = array();
        foreach ($allKeys as $v) {
            $v = explode(":", $v);
            if (is_array($v) && isset($v[1])) {
                $list[] = $v[1];
            }
        }
        
        return $list;
    }
    /**
     * Function to delete particular key
     * @param string $key
     */

    public function deleteKey($key)
    {
        self::$saveHandler->destroy($key);
    }

    /**
     * Returns memcached object
     * @return object
     */
    protected function getMemcachedObj()
    {
        $Resourceid = self::$saveHandler->getCacheStorge()
            ->getOptions()
            ->getResourceId();
        $memcached = self::$saveHandler->getCacheStorge()
            ->getOptions()
            ->getResourceManager()
            ->getResource($Resourceid);
        return $memcached;
    }

    /**
     * returns host name
     * @return String
     */
    protected function getHostName()
    {
        $request = new \Zend\Http\PhpEnvironment\Request();
        $uri = new \Zend\Uri\Uri($request->getUri());
        $host = $uri->getHost();
        return $host;
    }
}
