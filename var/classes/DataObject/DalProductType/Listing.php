<?php

namespace Pimcore\Model\DataObject\DalProductType;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\DalProductType|false current()
 * @method DataObject\DalProductType[] load()
 * @method DataObject\DalProductType[] getData()
 * @method DataObject\DalProductType[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "22";
protected $className = "DalProductType";


/**
* Filter by ProductType (Product Type)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByProductType ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("ProductType")->addListingFilter($this, $data, $operator);
	return $this;
}



}
