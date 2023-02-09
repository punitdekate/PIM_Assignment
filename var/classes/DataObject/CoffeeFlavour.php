<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - FlavourName [input]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\CoffeeFlavour\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\CoffeeFlavour\Listing|\Pimcore\Model\DataObject\CoffeeFlavour|null getByFlavourName($value, $limit = 0, $offset = 0, $objectTypes = null)
*/

class CoffeeFlavour extends Concrete
{
protected $o_classId = "12";
protected $o_className = "CoffeeFlavour";
protected $FlavourName;


/**
* @param array $values
* @return \Pimcore\Model\DataObject\CoffeeFlavour
*/
public static function create($values = array()) {
	$object = new static();
	$object->setValues($values);
	return $object;
}

/**
* Get FlavourName - Flavour Name
* @return string|null
*/
public function getFlavourName(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("FlavourName");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->FlavourName;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set FlavourName - Flavour Name
* @param string|null $FlavourName
* @return \Pimcore\Model\DataObject\CoffeeFlavour
*/
public function setFlavourName(?string $FlavourName)
{
	$this->FlavourName = $FlavourName;

	return $this;
}

}

