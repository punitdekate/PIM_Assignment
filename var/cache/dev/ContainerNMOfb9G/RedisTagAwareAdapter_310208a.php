<?php

namespace ContainerNMOfb9G;
include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Adapter/AbstractTagAwareAdapter.php';
include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Traits/RedisTrait.php';
include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Adapter/RedisTagAwareAdapter.php';

class RedisTagAwareAdapter_310208a extends \Symfony\Component\Cache\Adapter\RedisTagAwareAdapter implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Symfony\Component\Cache\Adapter\RedisTagAwareAdapter|null wrapped object, if the proxy is initialized
     */
    private $valueHolder33f7d = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer9d56b = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties0a12f = [
        
    ];

    public function commit() : bool
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'commit', array(), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->commit();
    }

    public function deleteItems(array $keys) : bool
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'deleteItems', array('keys' => $keys), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->deleteItems($keys);
    }

    public function invalidateTags(array $tags)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'invalidateTags', array('tags' => $tags), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->invalidateTags($tags);
    }

    public function hasItem($key)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'hasItem', array('key' => $key), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->hasItem($key);
    }

    public function clear(string $prefix = '')
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'clear', array('prefix' => $prefix), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->clear($prefix);
    }

    public function deleteItem($key)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'deleteItem', array('key' => $key), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->deleteItem($key);
    }

    public function getItem($key)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'getItem', array('key' => $key), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->getItem($key);
    }

    public function getItems(array $keys = [])
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'getItems', array('keys' => $keys), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->getItems($keys);
    }

    public function save(\Psr\Cache\CacheItemInterface $item)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'save', array('item' => $item), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->save($item);
    }

    public function saveDeferred(\Psr\Cache\CacheItemInterface $item)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'saveDeferred', array('item' => $item), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->saveDeferred($item);
    }

    public function enableVersioning(bool $enable = true)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'enableVersioning', array('enable' => $enable), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->enableVersioning($enable);
    }

    public function reset()
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'reset', array(), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->reset();
    }

    public function setLogger(\Psr\Log\LoggerInterface $logger)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'setLogger', array('logger' => $logger), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->setLogger($logger);
    }

    public function setCallbackWrapper(?callable $callbackWrapper) : callable
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'setCallbackWrapper', array('callbackWrapper' => $callbackWrapper), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->setCallbackWrapper($callbackWrapper);
    }

    public function get(string $key, callable $callback, ?float $beta = null, ?array &$metadata = null)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'get', array('key' => $key, 'callback' => $callback, 'beta' => $beta, 'metadata' => $metadata), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->get($key, $callback, $beta, $metadata);
    }

    public function delete(string $key) : bool
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'delete', array('key' => $key), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->delete($key);
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

        $instance->initializer9d56b = $initializer;

        return $instance;
    }

    public function __construct($redis, string $namespace = '', int $defaultLifetime = 0, ?\Symfony\Component\Cache\Marshaller\MarshallerInterface $marshaller = null)
    {
        static $reflection;

        if (! $this->valueHolder33f7d) {
            $reflection = $reflection ?? new \ReflectionClass('Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter');
            $this->valueHolder33f7d = $reflection->newInstanceWithoutConstructor();
        unset($this->maxIdLength, $this->logger);

        \Closure::bind(function (\Symfony\Component\Cache\Adapter\RedisTagAwareAdapter $instance) {
            unset($instance->redisEvictionPolicy, $instance->namespace, $instance->redis, $instance->marshaller);
        }, $this, 'Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter')->__invoke($this);

        \Closure::bind(function (\Symfony\Component\Cache\Adapter\AbstractTagAwareAdapter $instance) {
            unset($instance->namespace, $instance->defaultLifetime, $instance->namespaceVersion, $instance->versioningIsEnabled, $instance->deferred, $instance->ids, $instance->callbackWrapper, $instance->computing);
        }, $this, 'Symfony\\Component\\Cache\\Adapter\\AbstractTagAwareAdapter')->__invoke($this);

        }

        $this->valueHolder33f7d->__construct($redis, $namespace, $defaultLifetime, $marshaller);
    }

    public function & __get($name)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, '__get', ['name' => $name], $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        if (isset(self::$publicProperties0a12f[$name])) {
            return $this->valueHolder33f7d->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder33f7d;

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

        $targetObject = $this->valueHolder33f7d;
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
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        $realInstanceReflection = new \ReflectionClass('Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder33f7d;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder33f7d;
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
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, '__isset', array('name' => $name), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        $realInstanceReflection = new \ReflectionClass('Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder33f7d;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder33f7d;
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
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, '__unset', array('name' => $name), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        $realInstanceReflection = new \ReflectionClass('Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder33f7d;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder33f7d;
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
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, '__clone', array(), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        $this->valueHolder33f7d = clone $this->valueHolder33f7d;
    }

    public function __sleep()
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, '__sleep', array(), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return array('valueHolder33f7d');
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
        $this->initializer9d56b = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializer9d56b;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'initializeProxy', array(), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder33f7d;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder33f7d;
    }

    public function __destruct()
    {
        $this->initializer9d56b || $this->valueHolder33f7d->__destruct();
    }
}

if (!\class_exists('RedisTagAwareAdapter_310208a', false)) {
    \class_alias(__NAMESPACE__.'\\RedisTagAwareAdapter_310208a', 'RedisTagAwareAdapter_310208a', false);
}
