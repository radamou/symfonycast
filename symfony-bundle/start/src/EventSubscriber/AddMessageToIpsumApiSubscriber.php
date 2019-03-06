<?php

namespace App\EventSubscriber;

use KnpU\LoremIpsumBundle\Event\FilterApiResponseEvent;
use KnpU\LoremIpsumBundle\Event\KnpULoremIpsumEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddMessageToIpsumApiSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KnpULoremIpsumEvents::FILTER_API => 'onFilterApi',
        ];
    }

    public function onFilterApi(FilterApiResponseEvent $event)
    {
        $data = $event->getData();
        $data['message'] = 'Have a magical day!';
        $event->setData($data);
    }
}