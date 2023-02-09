<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - BrandId [input]
 * - Name [input]
 * - Logo [image]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\Brands\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\Brands\Listing|\Pimcore\Model\DataObject\Brands|null getByBrandId($value, $limit = 0, $offset = 0, $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Brands\Listing|\Pimcore\Model\DataObject\Brands|null getByName($value, $limit = 0, $offset = 0, $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Brands\Listing|\Pimcore\Model\DataObject\Brands|null getByLogo($value, $limit = 0, $offset = 0, $objectTypes = null)
*/

class Brands extends Concrete
{
protected $o_classId = "2";
protected $o_className = "Brands";
protected $BrandId;
protected $Name;
protected $Logo;


/**
* @param array $values
* @return \Pimcore\Model\DataObject\Brands
*/
public static function create($values = array()) {
	$object = new static();
	$object->setValues($values);
	return $object;
}

/**
* Get BrandId - Brand Id
* @return string|null
*/
public function getBrandId(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("BrandId");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->BrandId;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set BrandId - Brand Id
* @param string|null $BrandId
* @return \Pimcore\Model\DataObject\Brands
*/
public function setBrandId(?string $BrandId)
{
	$this->BrandId = $BrandId;

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
* @return \Pimcore\Model\DataObject\Brands
*/
public function setName(?string $Name)
{
	$this->Name = $Name;

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
* @return \Pimcore\Model\DataObject\Brands
*/
public function setLogo(?\Pimcore\Model\Asset\Image $Logo)
{
	$this->Logo = $Logo;

	return $this;
}

}

