<?php

namespace ContainerTzmOnGN;
include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Adapter/AbstractTagAwareAdapter.php';
include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Traits/RedisTrait.php';
include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Adapter/RedisTagAwareAdapter.php';

class RedisTagAwareAdapter_310208a extends \Symfony\Component\Cache\Adapter\RedisTagAwareAdapter implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Symfony\Component\Cache\Adapter\RedisTagAwareAdapter|null wrapped object, if the proxy is initialized
     */
    private $valueHolder839a3 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializeref79f = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiese8260 = [
        
    ];

    public function commit() : bool
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'commit', array(), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->commit();
    }

    public function deleteItems(array $keys) : bool
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'deleteItems', array('keys' => $keys), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->deleteItems($keys);
    }

    public function invalidateTags(array $tags)
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'invalidateTags', array('tags' => $tags), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->invalidateTags($tags);
    }

    public function hasItem($key)
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'hasItem', array('key' => $key), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->hasItem($key);
    }

    public function clear(string $prefix = '')
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'clear', array('prefix' => $prefix), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->clear($prefix);
    }

    public function deleteItem($key)
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'deleteItem', array('key' => $key), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->deleteItem($key);
    }

    public function getItem($key)
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'getItem', array('key' => $key), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->getItem($key);
    }

    public function getItems(array $keys = [])
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'getItems', array('keys' => $keys), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->getItems($keys);
    }

    public function save(\Psr\Cache\CacheItemInterface $item)
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'save', array('item' => $item), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->save($item);
    }

    public function saveDeferred(\Psr\Cache\CacheItemInterface $item)
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'saveDeferred', array('item' => $item), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->saveDeferred($item);
    }

    public function enableVersioning(bool $enable = true)
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'enableVersioning', array('enable' => $enable), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->enableVersioning($enable);
    }

    public function reset()
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'reset', array(), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->reset();
    }

    public function setLogger(\Psr\Log\LoggerInterface $logger)
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'setLogger', array('logger' => $logger), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->setLogger($logger);
    }

    public function setCallbackWrapper(?callable $callbackWrapper) : callable
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'setCallbackWrapper', array('callbackWrapper' => $callbackWrapper), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->setCallbackWrapper($callbackWrapper);
    }

    public function get(string $key, callable $callback, ?float $beta = null, ?array &$metadata = null)
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'get', array('key' => $key, 'callback' => $callback, 'beta' => $beta, 'metadata' => $metadata), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->get($key, $callback, $beta, $metadata);
    }

    public function delete(string $key) : bool
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'delete', array('key' => $key), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->delete($key);
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

        $instance->initializeref79f = $initializer;

        return $instance;
    }

    public function __construct($redis, string $namespace = '', int $defaultLifetime = 0, ?\Symfony\Component\Cache\Marshaller\MarshallerInterface $marshaller = null)
    {
        static $reflection;

        if (! $this->valueHolder839a3) {
            $reflection = $reflection ?? new \ReflectionClass('Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter');
            $this->valueHolder839a3 = $reflection->newInstanceWithoutConstructor();
        unset($this->maxIdLength, $this->logger);

        \Closure::bind(function (\Symfony\Component\Cache\Adapter\RedisTagAwareAdapter $instance) {
            unset($instance->redisEvictionPolicy, $instance->namespace, $instance->redis, $instance->marshaller);
        }, $this, 'Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter')->__invoke($this);

        \Closure::bind(function (\Symfony\Component\Cache\Adapter\AbstractTagAwareAdapter $instance) {
            unset($instance->namespace, $instance->defaultLifetime, $instance->namespaceVersion, $instance->versioningIsEnabled, $instance->deferred, $instance->ids, $instance->callbackWrapper, $instance->computing);
        }, $this, 'Symfony\\Component\\Cache\\Adapter\\AbstractTagAwareAdapter')->__invoke($this);

        }

        $this->valueHolder839a3->__construct($redis, $namespace, $defaultLifetime, $marshaller);
    }

    public function & __get($name)
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, '__get', ['name' => $name], $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        if (isset(self::$publicPropertiese8260[$name])) {
            return $this->valueHolder839a3->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder839a3;

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

        $targetObject = $this->valueHolder839a3;
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
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, '__set', array('name' => $name, 'value' => $value), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        $realInstanceReflection = new \ReflectionClass('Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder839a3;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder839a3;
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
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, '__isset', array('name' => $name), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        $realInstanceReflection = new \ReflectionClass('Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder839a3;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder839a3;
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
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, '__unset', array('name' => $name), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        $realInstanceReflection = new \ReflectionClass('Symfony\\Component\\Cache\\Adapter\\RedisTagAwareAdapter');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder839a3;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder839a3;
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
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, '__clone', array(), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        $this->valueHolder839a3 = clone $this->valueHolder839a3;
    }

    public function __sleep()
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, '__sleep', array(), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return array('valueHolder839a3');
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
        $this->initializeref79f = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializeref79f;
    }

    public function initializeProxy() : bool
    {
        return $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'initializeProxy', array(), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder839a3;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder839a3;
    }

    public function __destruct()
    {
        $this->initializeref79f || $this->valueHolder839a3->__destruct();
    }
}

if (!\class_exists('RedisTagAwareAdapter_310208a', false)) {
    \class_alias(__NAMESPACE__.'\\RedisTagAwareAdapter_310208a', 'RedisTagAwareAdapter_310208a', false);
}
