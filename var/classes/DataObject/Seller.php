<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\Seller\Listing getList(array $config = [])
*/

class Seller extends Concrete
{
protected $o_classId = "3";
protected $o_className = "Seller";


/**
* @param array $values
* @return \Pimcore\Model\DataObject\Seller
*/
public static function create($values = array()) {
	$object = new static();
	$object->setValues($values);
	return $object;
}

}
