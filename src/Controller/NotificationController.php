<?php

namespace App\Controller;

use Pimcore\Model\Notification\Service\NotificationService;

class NotificationController
{
    public function sendNotification(NotificationService $notificationService)
    {
        //$element = Asset::getById(1); // Optional

        $notificationService->sendToUser(
            5, // User recipient
            2, // User sender 0 - system
            'Object created',
            'Object successfully created using CSV',
            //$element // Optional linked element
        );
    }
}