<?php

namespace Pimcore\Model\DataObject\Category;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\Category|false current()
 * @method DataObject\Category[] load()
 * @method DataObject\Category[] getData()
 * @method DataObject\Category[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "17";
protected $className = "Category";


/**
* Filter by CategoryType (Category Type)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByCategoryType ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("CategoryType")->addListingFilter($this, $data, $operator);
	return $this;
}



}
