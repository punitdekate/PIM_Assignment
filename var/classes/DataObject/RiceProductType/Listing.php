<?php

namespace Pimcore\Model\DataObject\RiceProductType;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\RiceProductType|false current()
 * @method DataObject\RiceProductType[] load()
 * @method DataObject\RiceProductType[] getData()
 * @method DataObject\RiceProductType[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "23";
protected $className = "RiceProductType";


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
