<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - ProductType [input]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\CoffeeType\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\CoffeeType\Listing|\Pimcore\Model\DataObject\CoffeeType|null getByProductType($value, $limit = 0, $offset = 0, $objectTypes = null)
*/

class CoffeeType extends Concrete
{
protected $o_classId = "10";
protected $o_className = "CoffeeType";
protected $ProductType;


/**
* @param array $values
* @return \Pimcore\Model\DataObject\CoffeeType
*/
public static function create($values = array()) {
	$object = new static();
	$object->setValues($values);
	return $object;
}

/**
* Get ProductType - Product Type
* @return string|null
*/
public function getProductType(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("ProductType");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->ProductType;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set ProductType - Product Type
* @param string|null $ProductType
* @return \Pimcore\Model\DataObject\CoffeeType
*/
public function setProductType(?string $ProductType)
{
	$this->ProductType = $ProductType;

	return $this;
}

}

