<?php

namespace Pimcore\Model\DataObject\Staples;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;

class DalsAndPulses extends \Pimcore\Model\DataObject\Objectbrick {

protected $brickGetters = ['DalAndPulses'];


protected $DalAndPulses = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\DalAndPulses|null
*/
public function getDalAndPulses(bool $includeDeletedBricks = false)
{
	if(!$includeDeletedBricks &&
		isset($this->DalAndPulses) &&
		$this->DalAndPulses->getDoDelete()) {
			return null;
	}
	return $this->DalAndPulses;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\DalAndPulses $DalAndPulses
* @return \Pimcore\Model\DataObject\Staples\DalsAndPulses
*/
public function setDalAndPulses($DalAndPulses)
{
	$this->DalAndPulses = $DalAndPulses;
	return $this;
}

}

