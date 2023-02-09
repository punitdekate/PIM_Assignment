<?php

namespace Pimcore\Model\DataObject\Staples;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;

class SaltSugarAndJaggery extends \Pimcore\Model\DataObject\Objectbrick {

protected $brickGetters = ['SugarJaggeryAndSalt'];


protected $SugarJaggeryAndSalt = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\SugarJaggeryAndSalt|null
*/
public function getSugarJaggeryAndSalt(bool $includeDeletedBricks = false)
{
	if(!$includeDeletedBricks &&
		isset($this->SugarJaggeryAndSalt) &&
		$this->SugarJaggeryAndSalt->getDoDelete()) {
			return null;
	}
	return $this->SugarJaggeryAndSalt;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\SugarJaggeryAndSalt $SugarJaggeryAndSalt
* @return \Pimcore\Model\DataObject\Staples\SaltSugarAndJaggery
*/
public function setSugarJaggeryAndSalt($SugarJaggeryAndSalt)
{
	$this->SugarJaggeryAndSalt = $SugarJaggeryAndSalt;
	return $this;
}

}

