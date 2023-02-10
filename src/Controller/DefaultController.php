<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pimcore\Model\DataObject;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Model\DataObject\Grocery\Listing;


class DefaultController extends FrontendController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function defaultAction(Request $request): Response
    {
        return $this->render('default/default.html.twig');
    }

    /**
     * @Route("/test", methods={"GET", "POST"})
     */

    public function grocerieslist(Request $request): Response
    {
        $obj = new DataObject\Grocery\Listing();
        $BiscuitOut=[];

        foreach ($obj as $key => $objs) {
        
        $Biscuits=$objs->getFoodCategory()->getBiscuits();
        $Namkeen=$objs->getFoodCategory()->getNamkeen();
        if($Biscuits != NULL)
        {
            $BiscuitOut[]=array(
            "ItemID"=>$Biscuits->getItemId(),
            "ItemName"=>$Biscuits->getName(),
            "TasteType"=>$Biscuits->getTasteType(),
            "BiscuitType"=>$Biscuits->getBiscuitType(),
            "Flavour"=>$Biscuits->getFlavour(),
            "Weight"=>$Biscuits->getWeight()->getValue(),
            "QuantityOfItem"=>$Biscuits->getQuantityOfItem(),
            "PackOff"=>$Biscuits->getPackOff(),
            "Ingredients"=>$Biscuits->getIngrediant(),
            "Container"=>$Biscuits->getContainerType(),
            "EAN"=>$Biscuits->getEAN()
            );
            // $smallOutput[] = array(
            //     "Biscuit"=>$BiscuitOut
            // );
            $data[] = array(
                "SKU" => $objs->getSKU(),
                "Description" => $objs->getDescription(),
                "FoodType"=>$objs->getFoodType(),
                "Price"=>$objs->getPrice()->getValue(),
                "ShelfLife"=>$objs->getShelfLife()->getValue(),
                // "Category"=>$objs->getCategory(),
                // "Data"=>$smallOutput,
                "ManufacturingDate"=>$objs->getManufacutureDate(),
                "ExpiryDate"=>$objs->getExpiryDate(),
                
            );
        }
        elseif($Namkeen != NULL)
        {
            $NamkeenOut[]=array(
            "ItemID"=>$Namkeen->getItemId(),
            "ItemName"=>$Namkeen->getName(),
            "TasteType"=>$Namkeen->getTasteType(),
            "BiscuitType"=>$Namkeen->getSnacktype(),
            "Flavour"=>$Namkeen->getFlavour(),
            "Weight"=>$Namkeen->getWeight()->getValue(),
            "QuantityOfItem"=>$Namkeen->getQuantityOfItem(),
            "PackOff"=>$Namkeen->getPackOff(),
            "Ingredients"=>$Namkeen->getIngrediant(),
            "Container"=>$Namkeen->getContainerType(),
            "EAN"=>$Namkeen->getEAN()
            );
            $smallOutput[] = array(
                "Namkeen"=>$NamkeenOut
            );
           
        }
        $data[] = array(
            "SKU" => $objs->getSKU(),
            "Description" => $objs->getDescription(),
            "FoodType"=>$objs->getFoodType(),
            "Price"=>$objs->getPrice()->getValue(),
            "ShelfLife"=>$objs->getShelfLife()->getValue(),
            // "Category"=>$objs->getCategory(),
            "Data"=>$smallOutput,
            "ManufacturingDate"=>$objs->getManufacutureDate(),
            "ExpiryDate"=>$objs->getExpiryDate(),
            
        );
        }





        return $this->json(["success" => true, "data" => $data,'buiscuit'=>$BiscuitOut]);
    }
}
