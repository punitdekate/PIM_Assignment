<?php

namespace Symfony\Config\PimcoreDataImporter;

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This class is automatically generated to help in creating a config.
 */
class MessengerQueueProcessingConfig 
{
    private $activated;
    private $workerCountLifetime;
    private $workerItemCount;
    private $workerCountParallel;
    private $_usedProperties = [];

    /**
     * Activate dispatching messages after import was prepared. Will start import as soon as messages are processed via symfony messenger.
     * @default false
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function activated($value): self
    {
        $this->_usedProperties['activated'] = true;
        $this->activated = $value;

        return $this;
    }

    /**
     * Lifetime of tmp store entry for current worker count entry. After lifetime, the value will be cleared. Default to 30 minutes.
     * @default 1800
     * @param ParamConfigurator|int $value
     * @return $this
     */
    public function workerCountLifetime($value): self
    {
        $this->_usedProperties['workerCountLifetime'] = true;
        $this->workerCountLifetime = $value;

        return $this;
    }

    /**
     * Count of items imported per worker message.
     * @default 200
     * @param ParamConfigurator|int $value
     * @return $this
     */
    public function workerItemCount($value): self
    {
        $this->_usedProperties['workerItemCount'] = true;
        $this->workerItemCount = $value;

        return $this;
    }

    /**
     * Count of maximum parallel worker messages for parallel imports.
     * @default 3
     * @param ParamConfigurator|int $value
     * @return $this
     */
    public function workerCountParallel($value): self
    {
        $this->_usedProperties['workerCountParallel'] = true;
        $this->workerCountParallel = $value;

        return $this;
    }

    public function __construct(array $value = [])
    {
        if (array_key_exists('activated', $value)) {
            $this->_usedProperties['activated'] = true;
            $this->activated = $value['activated'];
            unset($value['activated']);
        }

        if (array_key_exists('worker_count_lifetime', $value)) {
            $this->_usedProperties['workerCountLifetime'] = true;
            $this->workerCountLifetime = $value['worker_count_lifetime'];
            unset($value['worker_count_lifetime']);
        }

        if (array_key_exists('worker_item_count', $value)) {
            $this->_usedProperties['workerItemCount'] = true;
            $this->workerItemCount = $value['worker_item_count'];
            unset($value['worker_item_count']);
        }

        if (array_key_exists('worker_count_parallel', $value)) {
            $this->_usedProperties['workerCountParallel'] = true;
            $this->workerCountParallel = $value['worker_count_parallel'];
            unset($value['worker_count_parallel']);
        }

        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }

    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['activated'])) {
            $output['activated'] = $this->activated;
        }
        if (isset($this->_usedProperties['workerCountLifetime'])) {
            $output['worker_count_lifetime'] = $this->workerCountLifetime;
        }
        if (isset($this->_usedProperties['workerItemCount'])) {
            $output['worker_item_count'] = $this->workerItemCount;
        }
        if (isset($this->_usedProperties['workerCountParallel'])) {
            $output['worker_count_parallel'] = $this->workerCountParallel;
        }

        return $output;
    }

}
