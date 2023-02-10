<?php

/**
 * Inheritance: yes
 * Variants: yes
 *
 * Fields Summary:
 * - ProductType [input]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\OilproductType\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\OilproductType\Listing|\Pimcore\Model\DataObject\OilproductType|null getByProductType($value, $limit = 0, $offset = 0, $objectTypes = null)
*/

class OilproductType extends Concrete
{
protected $o_classId = "25";
protected $o_className = "OilproductType";
protected $ProductType;


/**
* @param array $values
* @return \Pimcore\Model\DataObject\OilproductType
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

	if (\Pimcore\Model\DataObject::doGetInheritedValues() && $this->getClass()->getFieldDefinition("ProductType")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("ProductType");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set ProductType - Product Type
* @param string|null $ProductType
* @return \Pimcore\Model\DataObject\OilproductType
*/
public function setProductType(?string $ProductType)
{
	$this->ProductType = $ProductType;

	return $this;
}

}

