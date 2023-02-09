<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - PackerId [input]
 * - PackerName [input]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\Packer\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\Packer\Listing|\Pimcore\Model\DataObject\Packer|null getByPackerId($value, $limit = 0, $offset = 0, $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Packer\Listing|\Pimcore\Model\DataObject\Packer|null getByPackerName($value, $limit = 0, $offset = 0, $objectTypes = null)
*/

class Packer extends Concrete
{
protected $o_classId = "4";
protected $o_className = "Packer";
protected $PackerId;
protected $PackerName;


/**
* @param array $values
* @return \Pimcore\Model\DataObject\Packer
*/
public static function create($values = array()) {
	$object = new static();
	$object->setValues($values);
	return $object;
}

/**
* Get PackerId - Packer Id
* @return string|null
*/
public function getPackerId(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("PackerId");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->PackerId;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set PackerId - Packer Id
* @param string|null $PackerId
* @return \Pimcore\Model\DataObject\Packer
*/
public function setPackerId(?string $PackerId)
{
	$this->PackerId = $PackerId;

	return $this;
}

/**
* Get PackerName - Packer Name
* @return string|null
*/
public function getPackerName(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("PackerName");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->PackerName;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set PackerName - Packer Name
* @param string|null $PackerName
* @return \Pimcore\Model\DataObject\Packer
*/
public function setPackerName(?string $PackerName)
{
	$this->PackerName = $PackerName;

	return $this;
}

}

