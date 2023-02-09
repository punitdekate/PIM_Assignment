<?php

namespace ContainerHHe0Bg9;
include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Adapter/AbstractTagAwareAdapter.php';
include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Traits/RedisTrait.php';
include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Adapter/RedisTagAwareAdapter.php';

class RedisTagAwareAdapter_310208a extends \Symfony\Component\Cache\Adapter\RedisTagAwareAdapter implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Symfony\Component\Cache\Adapter\RedisTagAwareAdapter|null wrapped object, if the proxy is initialized
     */
    private $valueHolder9cd4c = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializerdbe6b = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties51100 = [
        
    ];

    public function commit() : bool
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'commit', array(), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->commit();
    }

    public function deleteItems(array $keys) : bool
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'deleteItems', array('keys' => $keys), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->deleteItems($keys);
    }

    public function invalidateTags(array $tags)
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'invalidateTags', array('tags' => $tags), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->invalidateTags($tags);
    }

    public function hasItem($key)
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'hasItem', array('key' => $key), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->hasItem($key);
    }

    public function clear(string $prefix = '')
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'clear', array('prefix' => $prefix), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->clear($prefix);
    }

    public function deleteItem($key)
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'deleteItem', array('key' => $key), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->deleteItem($key);
    }

    public function getItem($key)
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'getItem', array('key' => $key), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->getItem($key);
    }

    public function getItems(array $keys = [])
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'getItems', array('keys' => $keys), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->getItems($keys);
    }

    public function save(\Psr\Cache\CacheItemInterface $item)
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'save', array('item' => $item), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->save($item);
    }

    public function saveDeferred(\Psr\Cache\CacheItemInterface $item)
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'saveDeferred', array('item' => $item), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->saveDeferred($item);
    }

    public function enableVersioning(bool $enable = true)
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'enableVersioning', array('enable' => $enable), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->enableVersioning($enable);
    }

    public function reset()
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'reset', array(), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->reset();
    }

    public function setLogger(\Psr\Log\LoggerInterface $logger)
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'setLogger', array('logger' => $logger), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->setLogger($logger);
    }

    public function setCallbackWrapper(?callable $callbackWrapper) : callable
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'setCallbackWrapper', array('callbackWrapper' => $callbackWrapper), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->setCallbackWrapper($callbackWrapper);
    }

    public function get(string $key, callable $callback, ?float $beta = null, ?array &$metadata = null)
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'get', array('key' => $key, 'callback' => $callback, 'beta' => $beta, 'metadata' => $metadata), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->get($key, $callback, $beta, $metadata);
    }

    public function delete(string $key) : bool
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'delete', array('key' => $key), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->delete($key);
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        unset($instance->maxIdLength, $instance->logger);

        \Closure::bind(function (\Symfony\Component\Cache\Adapter\RedisTagAwareAdapter $instance) {
            unset($instance->redisEvictionPolicy, $instance->namespace, $instance->redis, $instance->marshaller);
        }, $instance, 'Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter')->__invoke($instance);

        \Closure::bind(function (\Symfony\Component\Cache\Adapter\AbstractTagAwareAdapter $instance) {
            unset($instance->namespace, $instance->defaultLifetime, $instance->namespaceVersion, $instance->versioningIsEnabled, $instance->deferred, $instance->ids, $instance->callbackWrapper, $instance->computing);
        }, $instance, 'Symfony\\Component\\Cache\\Adapter\\AbstractTagAwareAdapter')->__invoke($instance);

        $instance->initializerdbe6b = $initializer;

        return $instance;
    }

    public function __construct($redis, string $namespace = '', int $defaultLifetime = 0, ?\Symfony\Component\Cache\Marshaller\MarshallerInterface $marshaller = null)
    {
        static $reflection;

        if (! $this->valueHolder9cd4c) {
            $reflection = $reflection ?? new \ReflectionClass('Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter');
            $this->valueHolder9cd4c = $reflection->newInstanceWithoutConstructor();
        unset($this->maxIdLength, $this->logger);

        \Closure::bind(function (\Symfony\Component\Cache\Adapter\RedisTagAwareAdapter $instance) {
            unset($instance->redisEvictionPolicy, $instance->namespace, $instance->redis, $instance->marshaller);
        }, $this, 'Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter')->__invoke($this);

        \Closure::bind(function (\Symfony\Component\Cache\Adapter\AbstractTagAwareAdapter $instance) {
            unset($instance->namespace, $instance->defaultLifetime, $instance->namespaceVersion, $instance->versioningIsEnabled, $instance->deferred, $instance->ids, $instance->callbackWrapper, $instance->computing);
        }, $this, 'Symfony\\Component\\Cache\\Adapter\\AbstractTagAwareAdapter')->__invoke($this);

        }

        $this->valueHolder9cd4c->__construct($redis, $namespace, $defaultLifetime, $marshaller);
    }

    public function & __get($name)
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, '__get', ['name' => $name], $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        if (isset(self::$publicProperties51100[$name])) {
            return $this->valueHolder9cd4c->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder9cd4c;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder9cd4c;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, '__set', array('name' => $name, 'value' => $value), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        $realInstanceReflection = new \ReflectionClass('Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder9cd4c;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder9cd4c;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, '__isset', array('name' => $name), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        $realInstanceReflection = new \ReflectionClass('Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder9cd4c;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder9cd4c;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, '__unset', array('name' => $name), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        $realInstanceReflection = new \ReflectionClass('Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder9cd4c;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder9cd4c;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, '__clone', array(), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        $this->valueHolder9cd4c = clone $this->valueHolder9cd4c;
    }

    public function __sleep()
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, '__sleep', array(), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return array('valueHolder9cd4c');
    }

    public function __wakeup()
    {
        unset($this->maxIdLength, $this->logger);

        \Closure::bind(function (\Symfony\Component\Cache\Adapter\RedisTagAwareAdapter $instance) {
            unset($instance->redisEvictionPolicy, $instance->namespace, $instance->redis, $instance->marshaller);
        }, $this, 'Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter')->__invoke($this);

        \Closure::bind(function (\Symfony\Component\Cache\Adapter\AbstractTagAwareAdapter $instance) {
            unset($instance->namespace, $instance->defaultLifetime, $instance->namespaceVersion, $instance->versioningIsEnabled, $instance->deferred, $instance->ids, $instance->callbackWrapper, $instance->computing);
        }, $this, 'Symfony\\Component\\Cache\\Adapter\\AbstractTagAwareAdapter')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializerdbe6b = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializerdbe6b;
    }

    public function initializeProxy() : bool
    {
        return $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'initializeProxy', array(), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder9cd4c;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder9cd4c;
    }

    public function __destruct()
    {
        $this->initializerdbe6b || $this->valueHolder9cd4c->__destruct();
    }
}

if (!\class_exists('RedisTagAwareAdapter_310208a', false)) {
    \class_alias(__NAMESPACE__.'\\RedisTagAwareAdapter_310208a', 'RedisTagAwareAdapter_310208a', false);
}
