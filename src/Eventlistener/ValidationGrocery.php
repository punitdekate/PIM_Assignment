<?php
namespace App\Eventlistener;
use Pimcore\Model\DataObject\Grocery;
use Pimcore\Model\DataObject\Brands;
use App\Controller\NotificationController;
use Pimcore\Model\Notification\Service\NotificationService;
use Pimcore\Model\Notification\Service;
class ValidationGrocery
{
    public function Validate(\Pimcore\Event\Model\DataObjectEvent $event)
    {
        $object = $event->getObject();
        if ($object instanceof Grocery) {
            $manufacture = $object->getManufacutureDate();
            $expire = $object->getExpiryDate();
            if ($expire<$manufacture) {
                throw new \Exception("expiry date can not be less");
            }
        }
    }
    public function notificationListener(\Pimcore\Event\Model\DataObjectEvent $event)
    {
        $object = $event->getObject();
        if ($object instanceof Brands) {

            //if ($object->getPublished() == True) {
            $obj = new NotificationController;
            $userService = new Service\UserService;
            $notificationService = new NotificationService($userService);
            $obj->sendNotification($notificationService);
            //}
        }
    }

 

}