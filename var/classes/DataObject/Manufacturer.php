<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - ManufacturerName [input]
 * - Logo [image]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\Manufacturer\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\Manufacturer\Listing|\Pimcore\Model\DataObject\Manufacturer|null getByManufacturerName($value, $limit = 0, $offset = 0, $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Manufacturer\Listing|\Pimcore\Model\DataObject\Manufacturer|null getByLogo($value, $limit = 0, $offset = 0, $objectTypes = null)
*/

class Manufacturer extends Concrete
{
protected $o_classId = "6";
protected $o_className = "Manufacturer";
protected $ManufacturerName;
protected $Logo;


/**
* @param array $values
* @return \Pimcore\Model\DataObject\Manufacturer
*/
public static function create($values = array()) {
	$object = new static();
	$object->setValues($values);
	return $object;
}

/**
* Get ManufacturerName - Manufacturer Name
* @return string|null
*/
public function getManufacturerName(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("ManufacturerName");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->ManufacturerName;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set ManufacturerName - Manufacturer Name
* @param string|null $ManufacturerName
* @return \Pimcore\Model\DataObject\Manufacturer
*/
public function setManufacturerName(?string $ManufacturerName)
{
	$this->ManufacturerName = $ManufacturerName;

	return $this;
}

/**
* Get Logo - Logo
* @return \Pimcore\Model\Asset\Image|null
*/
public function getLogo(): ?\Pimcore\Model\Asset\Image
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("Logo");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->Logo;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set Logo - Logo
* @param \Pimcore\Model\Asset\Image|null $Logo
* @return \Pimcore\Model\DataObject\Manufacturer
*/
public function setLogo(?\Pimcore\Model\Asset\Image $Logo)
{
	$this->Logo = $Logo;

	return $this;
}

}

