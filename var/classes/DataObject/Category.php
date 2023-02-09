<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - CategoryType [input]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\Category\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\Category\Listing|\Pimcore\Model\DataObject\Category|null getByCategoryType($value, $limit = 0, $offset = 0, $objectTypes = null)
*/

class Category extends Concrete
{
protected $o_classId = "17";
protected $o_className = "Category";
protected $CategoryType;


/**
* @param array $values
* @return \Pimcore\Model\DataObject\Category
*/
public static function create($values = array()) {
	$object = new static();
	$object->setValues($values);
	return $object;
}

/**
* Get CategoryType - Category Type
* @return string|null
*/
public function getCategoryType(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("CategoryType");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->CategoryType;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set CategoryType - Category Type
* @param string|null $CategoryType
* @return \Pimcore\Model\DataObject\Category
*/
public function setCategoryType(?string $CategoryType)
{
	$this->CategoryType = $CategoryType;

	return $this;
}

}

