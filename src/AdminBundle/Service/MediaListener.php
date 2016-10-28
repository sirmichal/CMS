<?php

namespace AdminBundle\Service;

use AdminBundle\Entity\Media;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Vich\UploaderBundle\Event as VichEvent;

class MediaListener implements EventSubscriberInterface {

    /**
     * @return array
     */
    public static function getSubscribedEvents() {
        return [
            VichEvent\Events::POST_UPLOAD => 'postUpload'
        ];
    }

    /**
     * @param VichEvent\Event $event
     */
    public function postUpload(VichEvent\Event $event) {
        /** @var Media $object */
        $object = $event->getObject();

        $file = $object->getFile();
        $object->setFileSize($file->getSize());
        $object->setMimeType($file->getMimeType());
    }

}
