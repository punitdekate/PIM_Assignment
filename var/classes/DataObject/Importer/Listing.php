<?php

namespace Pimcore\Model\DataObject\Importer;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\Importer|false current()
 * @method DataObject\Importer[] load()
 * @method DataObject\Importer[] getData()
 * @method DataObject\Importer[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "5";
protected $className = "Importer";


/**
* Filter by ImporterId (Importer Id)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByImporterId ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("ImporterId")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by ImporterName (Importer Name)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByImporterName ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("ImporterName")->addListingFilter($this, $data, $operator);
	return $this;
}



}
