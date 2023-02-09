<?php

namespace Pimcore\Model\DataObject\Packer;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\Packer|false current()
 * @method DataObject\Packer[] load()
 * @method DataObject\Packer[] getData()
 * @method DataObject\Packer[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "4";
protected $className = "Packer";


/**
* Filter by PackerId (Packer Id)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByPackerId ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("PackerId")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by PackerName (Packer Name)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByPackerName ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("PackerName")->addListingFilter($this, $data, $operator);
	return $this;
}



}
