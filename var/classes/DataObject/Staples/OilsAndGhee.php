<?php

namespace Pimcore\Model\DataObject\Staples;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;

class OilsAndGhee extends \Pimcore\Model\DataObject\Objectbrick {

protected $brickGetters = ['GheeAndOils'];


protected $GheeAndOils = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\GheeAndOils|null
*/
public function getGheeAndOils(bool $includeDeletedBricks = false)
{
	if(!$includeDeletedBricks &&
		isset($this->GheeAndOils) &&
		$this->GheeAndOils->getDoDelete()) {
			return null;
	}
	return $this->GheeAndOils;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\GheeAndOils $GheeAndOils
* @return \Pimcore\Model\DataObject\Staples\OilsAndGhee
*/
public function setGheeAndOils($GheeAndOils)
{
	$this->GheeAndOils = $GheeAndOils;
	return $this;
}

}

