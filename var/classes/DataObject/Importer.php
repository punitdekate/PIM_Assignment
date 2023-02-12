<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - ImporterId [input]
 * - ImporterName [input]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\Importer\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\Importer\Listing|\Pimcore\Model\DataObject\Importer|null getByImporterId($value, $limit = 0, $offset = 0, $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Importer\Listing|\Pimcore\Model\DataObject\Importer|null getByImporterName($value, $limit = 0, $offset = 0, $objectTypes = null)
*/

class Importer extends Concrete
{
protected $o_classId = "5";
protected $o_className = "Importer";
protected $ImporterId;
protected $ImporterName;


/**
* @param array $values
* @return \Pimcore\Model\DataObject\Importer
*/
public static function create($values = array()) {
	$object = new static();
	$object->setValues($values);
	return $object;
}

/**
* Get ImporterId - Importer Id
* @return string|null
*/
public function getImporterId(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("ImporterId");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->ImporterId;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set ImporterId - Importer Id
* @param string|null $ImporterId
* @return \Pimcore\Model\DataObject\Importer
*/
public function setImporterId(?string $ImporterId)
{
	$this->ImporterId = $ImporterId;

	return $this;
}

/**
* Get ImporterName - Importer Name
* @return string|null
*/
public function getImporterName(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("ImporterName");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->ImporterName;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set ImporterName - Importer Name
* @param string|null $ImporterName
* @return \Pimcore\Model\DataObject\Importer
*/
public function setImporterName(?string $ImporterName)
{
	$this->ImporterName = $ImporterName;

	return $this;
}

}

