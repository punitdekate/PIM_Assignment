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
* @method static \Pimcore\Model\DataObject\BiscuitFlavour\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\BiscuitFlavour\Listing|\Pimcore\Model\DataObject\BiscuitFlavour|null getByFlavourName($value, $limit = 0, $offset = 0, $objectTypes = null)
*/

class BiscuitFlavour extends Concrete
{
protected $o_classId = "13";
protected $o_className = "BiscuitFlavour";
protected $FlavourName;


/**
* @param array $values
* @return \Pimcore\Model\DataObject\BiscuitFlavour
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
* @return \Pimcore\Model\DataObject\BiscuitFlavour
*/
public function setFlavourName(?string $FlavourName)
{
	$this->FlavourName = $FlavourName;

	return $this;
}

}

