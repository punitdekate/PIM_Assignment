<?php

namespace App\DynamicDropdown;

use Pimcore\Model\DataObject\ClassDefinition\DynamicOptionsProvider\SelectOptionsProviderInterface;
use Pimcore\Model\DataObject;

/**
 * Need to provide App\DynamicDropdown\CustomOptions in options provider class
 */
class Snacktype implements SelectOptionsProviderInterface
{
    public function getDefaultValue($context, $fieldDefinition)
    {
        return "db_value_1";
    }

    function getOptions($context, $fieldDefinition)
    {
        $items=new Dataobject\Snacktype\Listing();
        $items->setOrderKey("RAND()",false);
        $arr=[];
        foreach ($items as $item){
            array_push($arr,["value"=>$item->getProductType(),"key"=>$item->getProductType()]);
    }
        return $arr;
    }

    function hasStaticOptions($context, $fieldDefinition)
    {
        return true;
    }
}