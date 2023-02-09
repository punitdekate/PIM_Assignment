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
* @method static \Pimcore\Model\DataObject\NamkeenType\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\NamkeenType\Listing|\Pimcore\Model\DataObject\NamkeenType|null getByProductType($value, $limit = 0, $offset = 0, $objectTypes = null)
*/

class NamkeenType extends Concrete
{
protected $o_classId = "8";
protected $o_className = "NamkeenType";
protected $ProductType;


/**
* @param array $values
* @return \Pimcore\Model\DataObject\NamkeenType
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
* @return \Pimcore\Model\DataObject\NamkeenType
*/
public function setProductType(?string $ProductType)
{
	$this->ProductType = $ProductType;

	return $this;
}

}

