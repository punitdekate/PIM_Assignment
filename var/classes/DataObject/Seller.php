<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - SellerId [input]
 * - Name [input]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\Seller\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\Seller\Listing|\Pimcore\Model\DataObject\Seller|null getBySellerId($value, $limit = 0, $offset = 0, $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Seller\Listing|\Pimcore\Model\DataObject\Seller|null getByName($value, $limit = 0, $offset = 0, $objectTypes = null)
*/

class Seller extends Concrete
{
protected $o_classId = "3";
protected $o_className = "Seller";
protected $SellerId;
protected $Name;


/**
* @param array $values
* @return \Pimcore\Model\DataObject\Seller
*/
public static function create($values = array()) {
	$object = new static();
	$object->setValues($values);
	return $object;
}

/**
* Get SellerId - Seller Id
* @return string|null
*/
public function getSellerId(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("SellerId");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->SellerId;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set SellerId - Seller Id
* @param string|null $SellerId
* @return \Pimcore\Model\DataObject\Seller
*/
public function setSellerId(?string $SellerId)
{
	$this->SellerId = $SellerId;

	return $this;
}

/**
* Get Name - Name
* @return string|null
*/
public function getName(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("Name");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->Name;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set Name - Name
* @param string|null $Name
* @return \Pimcore\Model\DataObject\Seller
*/
public function setName(?string $Name)
{
	$this->Name = $Name;

	return $this;
}

}

