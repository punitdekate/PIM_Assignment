<?php

namespace Pimcore\Model\DataObject\Manufacturer;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\Manufacturer|false current()
 * @method DataObject\Manufacturer[] load()
 * @method DataObject\Manufacturer[] getData()
 * @method DataObject\Manufacturer[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "6";
protected $className = "Manufacturer";


/**
* Filter by ManufacturerName (Manufacturer Name)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByManufacturerName ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("ManufacturerName")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by Logo (Logo)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByLogo ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("Logo")->addListingFilter($this, $data, $operator);
	return $this;
}



}
