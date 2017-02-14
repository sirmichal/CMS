<?php

namespace AdminBundle\Service;

use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;

/**
 * Add data after serialization
 *
 */
class SerializationListenerService implements EventSubscriberInterface {

    private $imagineCacheManager;

    public function __construct($imagineCacheManager) {
        $this->imagineCacheManager = $imagineCacheManager;
    }

    public static function getSubscribedEvents() {
        return array(
            array('event' => 'serializer.post_serialize', 'class' => 'AdminBundle\Entity\Media', 'method' => 'onPostSerialize'),
            array('event' => 'serializer.post_serialize', 'class' => 'AdminBundle\Entity\Category', 'method' => 'onPostSerialize'),
        );
    }

    public function onPostSerialize(ObjectEvent $event) {
        $groups = $event->getContext()->attributes->get('groups')->get();
        $object = $event->getObject();
        
        if($object instanceof \AdminBundle\Entity\Media) {
            if (in_array('details', $groups)) {
                $path = 'media/' . $object->getName();
                $filter = 'single_image';
                
                $cacheImagePath = $this->imagineCacheManager->getBrowserPath($path, $filter);
                $imageInfo = getimagesize($path);
                
                $event->getVisitor()->addData('width', $imageInfo[0]);
                $event->getVisitor()->addData('height', $imageInfo[1]);
                $event->getVisitor()->addData('mime', $imageInfo['mime']);
                $event->getVisitor()->addData('size', filesize($path));
                $event->getVisitor()->addData('cacheImagePath', $cacheImagePath);
            }
        }
    }

}
