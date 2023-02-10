<?php

/**
 * Inheritance: yes
 * Variants: yes
 *
 * Fields Summary:
 * - FlavourName [input]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\BakingFlavour\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\BakingFlavour\Listing|\Pimcore\Model\DataObject\BakingFlavour|null getByFlavourName($value, $limit = 0, $offset = 0, $objectTypes = null)
*/

class BakingFlavour extends Concrete
{
protected $o_classId = "18";
protected $o_className = "BakingFlavour";
protected $FlavourName;


/**
* @param array $values
* @return \Pimcore\Model\DataObject\BakingFlavour
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

	if (\Pimcore\Model\DataObject::doGetInheritedValues() && $this->getClass()->getFieldDefinition("FlavourName")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("FlavourName");
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
* Set FlavourName - Flavour Name
* @param string|null $FlavourName
* @return \Pimcore\Model\DataObject\BakingFlavour
*/
public function setFlavourName(?string $FlavourName)
{
	$this->FlavourName = $FlavourName;

	return $this;
}

}
