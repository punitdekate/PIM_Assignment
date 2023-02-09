<?php

namespace Pimcore\Model\DataObject\Staples;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;

class RiceAndRiceProducts extends \Pimcore\Model\DataObject\Objectbrick {

protected $brickGetters = ['RiceAndRiceProducts'];


protected $RiceAndRiceProducts = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\RiceAndRiceProducts|null
*/
public function getRiceAndRiceProducts(bool $includeDeletedBricks = false)
{
	if(!$includeDeletedBricks &&
		isset($this->RiceAndRiceProducts) &&
		$this->RiceAndRiceProducts->getDoDelete()) {
			return null;
	}
	return $this->RiceAndRiceProducts;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\RiceAndRiceProducts $RiceAndRiceProducts
* @return \Pimcore\Model\DataObject\Staples\RiceAndRiceProducts
*/
public function setRiceAndRiceProducts($RiceAndRiceProducts)
{
	$this->RiceAndRiceProducts = $RiceAndRiceProducts;
	return $this;
}

}

