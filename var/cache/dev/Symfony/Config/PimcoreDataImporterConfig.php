<?php

namespace Symfony\Config;

require_once __DIR__.\DIRECTORY_SEPARATOR.'PimcoreDataImporter'.\DIRECTORY_SEPARATOR.'MessengerQueueProcessingConfig.php';

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This class is automatically generated to help in creating a config.
 */
class PimcoreDataImporterConfig implements \Symfony\Component\Config\Builder\ConfigBuilderInterface
{
    private $messengerQueueProcessing;
    private $_usedProperties = [];

    public function messengerQueueProcessing(array $value = []): \Symfony\Config\PimcoreDataImporter\MessengerQueueProcessingConfig
    {
        if (null === $this->messengerQueueProcessing) {
            $this->_usedProperties['messengerQueueProcessing'] = true;
            $this->messengerQueueProcessing = new \Symfony\Config\PimcoreDataImporter\MessengerQueueProcessingConfig($value);
        } elseif (0 < \func_num_args()) {
            throw new InvalidConfigurationException('The node created by "messengerQueueProcessing()" has already been initialized. You cannot pass values the second time you call messengerQueueProcessing().');
        }

        return $this->messengerQueueProcessing;
    }

    public function getExtensionAlias(): string
    {
        return 'pimcore_data_importer';
    }

    public function __construct(array $value = [])
    {
        if (array_key_exists('messenger_queue_processing', $value)) {
            $this->_usedProperties['messengerQueueProcessing'] = true;
            $this->messengerQueueProcessing = new \Symfony\Config\PimcoreDataImporter\MessengerQueueProcessingConfig($value['messenger_queue_processing']);
            unset($value['messenger_queue_processing']);
        }

        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }

    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['messengerQueueProcessing'])) {
            $output['messenger_queue_processing'] = $this->messengerQueueProcessing->toArray();
        }

        return $output;
    }

}
